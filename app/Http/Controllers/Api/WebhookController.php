<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class WebhookController extends Controller {
    public function handleStripe(Request $request) {
        $event = $request->all();
        $type = $event['type'] ?? null;

        Log::info("Stripe Webhook Received: {$type}", ['event' => $event]);

        switch ($type) {
            case 'checkout.session.completed':
                $session = $event['data']['object'];
                $this->handleCheckoutCompleted($session);
                break;
            case 'payment_intent.payment_failed':
                $session = $event['data']['object'];
                $this->handlePaymentFailed($session);
                break;
        }

        return response()->json(['status' => 'success']);
    }

    protected function handleCheckoutCompleted($session) {
        $sessionId = $session['id'];

        DB::transaction(function () use ($sessionId) {
            // Check for idempotency: if already paid, skip
            $payment = Payment::where('stripe_session_id', $sessionId)->lockForUpdate()->first();
            
            if ($payment && $payment->status !== 'paid') {
                $payment->update([
                    'status' => 'paid',
                    'payment_method' => 'stripe_card'
                ]);

                $payment->booking->update(['status' => 'confirmed']);
                Log::info("Payment confirmed for Booking ID: {$payment->booking_id}");
            }
        });
    }

    protected function handlePaymentFailed($session) {
        $sessionId = $session['id'];
        $payment = Payment::where('stripe_session_id', $sessionId)->first();
        if ($payment) {
            $payment->update(['status' => 'failed']);
            Log::warning("Payment failed for Booking ID: {$payment->booking_id}");
        }
    }
}
