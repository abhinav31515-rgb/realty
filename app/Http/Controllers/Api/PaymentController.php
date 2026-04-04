<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class PaymentController extends Controller
{
    public function createCheckoutSession(Request $request, Booking $booking)
    {
        $stripe = new StripeClient(config('services.stripe.secret'));

        $session = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => "Booking Deposit: " . $booking->property->title,
                    ],
                    'unit_amount' => 500000, // $5,000.00 deposit
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
