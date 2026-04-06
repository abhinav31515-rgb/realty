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

        // STRICT: Fail closed in non-local environments if secret is missing
        if (!$endpointSecret && !app()->isLocal() && !app()->runningUnitTests()) {
            Log::critical("SECURITY ALERT: Stripe Webhook Secret is missing in production/staging environment.");
            return response()->json(['error' => 'Webhook service misconfigured'], 500);
        }

        try {
            if ($endpointSecret) {
                $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
            } else {
                // Local/Testing fallback only
                $event = json_decode($payload, true);
            }
        } catch (SignatureVerificationException $e) {
            Log::error("Stripe Webhook Signature Failed: {$e->getMessage()}");
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\Exception $e) {
            Log::error("Stripe Webhook Error: {$e->getMessage()}");
            return response()->json(['error' => 'Internal server error'], 500);
        }

        $type = $event['type'] ?? ($event->type ?? null);
        $object = $event['data']['object'] ?? ($event->data->object ?? null);
        
        if (!$type || !$object) {
            return response()->json(['error' => 'Invalid payload'], 400);
        }

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
                Log::info("Payment confirmed via Webhook for Booking: {$bookingUuid}");
            }
        });
    }

    protected function handlePaymentFailed($session) {
        $sessionId = $session['id'] ?? null;
        $payment = Payment::where('stripe_session_id', $sessionId)->first();
        if ($payment) {
            $payment->update(['status' => 'failed']);
            Log::warning("Payment failed via Webhook for Booking ID: {$payment->booking_id}");
        }
    }
}
