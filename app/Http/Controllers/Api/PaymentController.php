<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller {
    public function createCheckoutSession(Request $request, Booking $booking) {
        // Authorization: Only the customer who owns the booking can pay
        if ($request->user()->id !== $booking->customer_id) {
            abort(403, 'Unauthorized. Only the booking owner can initiate payment.');
        }

        // Production-Grade Stripe Integration
        $apiKey = config('services.stripe.secret') ?? env('STRIPE_SECRET', 'sk_test_mock');
        Stripe::setApiKey($apiKey);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => "Concierge Showing for: {$booking->property->title}",
                    ],
                    'unit_amount' => 50000, // $500.00
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => config('app.url') . '/payment/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => config('app.url') . '/payment/cancel',
            'client_reference_id' => $booking->uuid,
            'metadata' => [
                'booking_id' => $booking->id,
                'booking_uuid' => $booking->uuid
            ]
        ]);

        Payment::create([
            'booking_id' => $booking->id,
            'amount' => 500.00,
            'status' => 'pending',
            'stripe_session_id' => $session->id,
        ]);

        return response()->json([
            'id' => $session->id,
            'url' => $session->url,
        ]);
    }
}
