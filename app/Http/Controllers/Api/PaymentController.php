<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Stripe\StripeClient;
class PaymentController extends Controller {
    public function createCheckoutSession(Request $request, Booking $booking) {
        // Strict Authorization: Only the customer who made the booking can pay
        if ($request->user()->id !== $booking->customer_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $stripe = new StripeClient(config('services.stripe.secret'));
        $session = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => ['name' => "Booking Deposit: " . $booking->property->title],
                    'unit_amount' => 500000,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/dashboard?payment=success'),
            'cancel_url' => url('/properties/' . $booking->property_id . '?payment=cancelled'),
        ]);
        return response()->json(['url' => $session->url]);
    }
}
