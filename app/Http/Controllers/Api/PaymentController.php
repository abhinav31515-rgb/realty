<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller {
    public function createCheckoutSession(Request $request, Booking $booking) {
        // Mock Stripe checkout for now
        $sessionId = 'cs_test_' . uniqid();
        
        Payment::create([
            'booking_id' => $booking->id,
            'amount' => 500.00, // Concierge fee
            'status' => 'pending',
            'stripe_session_id' => $sessionId,
        ]);

        return response()->json([
            'url' => "https://checkout.stripe.com/pay/{$sessionId}",
            'session_id' => $sessionId
        ]);
    }
}
