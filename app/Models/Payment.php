<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Payment extends Model {
    protected $fillable = ['uuid', 'booking_id', 'amount', 'status', 'stripe_session_id', 'payment_method'];

    protected static function booted() {
        static::creating(function ($payment) {
            $payment->uuid = (string) Str::uuid();
        });
    }

    public function booking(): BelongsTo {
        return $this->belongsTo(Booking::class);
    }
}
