<?php
namespace App\Models;

use App\Jobs\SendShowingRequestEmail;
use App\Jobs\SendSupabaseNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Booking extends Model {
    use SoftDeletes, HasFactory;

    protected $fillable = ['uuid', 'property_id', 'customer_id', 'agent_id', 'scheduled_at', 'status', 'metadata'];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'metadata' => 'array',
    ];

    protected static function booted() {
        static::creating(function ($booking) {
            $booking->uuid = (string) Str::uuid();
        });
    }

    public function getRouteKeyName() {
        return 'uuid';
    }

    public function property(): BelongsTo {
        return $this->belongsTo(Property::class);
    }

    public function customer(): BelongsTo {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function agent(): BelongsTo {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
