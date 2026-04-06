<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class WebhookController extends Controller {
    public function handleStripe(Request $request) {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret') ?? env('STRIPE_WEBHOOK_SECRET');

        try {
            // Production Security: Verify the Stripe Signature
            if ($endpointSecret) {
                $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
            } else {
                $event = json_decode($payload, true);
            }
        } catch (SignatureVerificationException $e) {
            Log::error("Stripe Webhook Signature Failed: {$e->getMessage()}");
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $type = $event['type'] ?? ($event->type ?? null);
        Log::info("Stripe Webhook Received: {$type}");

        $object = $event['data']['object'] ?? ($event->data->object ?? null);
        
        switch ($type) {
            case 'checkout.session.completed':
                $this->handleCheckoutCompleted($object);
                break;
            case 'payment_intent.payment_failed':
                $this->handlePaymentFailed($object);
                break;
        }

        return response()->json(['status' => 'success']);
    }

    protected function handleCheckoutCompleted($session) {
        $sessionId = $session['id'] ?? null;
        $bookingUuid = $session['client_reference_id'] ?? ($session['metadata']['booking_uuid'] ?? null);

        DB::transaction(function () use ($sessionId, $bookingUuid) {
            $payment = Payment::where('stripe_session_id', $sessionId)
                ->lockForUpdate()
                ->first();
            
            if ($payment && $payment->status !== 'paid') {
                $payment->update([
                    'status' => 'paid',
                    'payment_method' => 'stripe_card'
                ]);

                $payment->booking->update(['status' => 'confirmed']);
                Log::info("Payment confirmed for Booking UUID: {$bookingUuid}");
            }
        });
    }

    protected function handlePaymentFailed($session) {
        $sessionId = $session['id'] ?? null;
        $payment = Payment::where('stripe_session_id', $sessionId)->first();
        if ($payment) {
            $payment->update(['status' => 'failed']);
            Log::warning("Payment failed for Booking ID: {$payment->booking_id}");
        }
    }
}
