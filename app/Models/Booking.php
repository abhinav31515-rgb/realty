<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model {
    use SoftDeletes, HasFactory;

    protected $fillable = ['property_id', 'customer_id', 'agent_id', 'status', 'scheduled_at'];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'status' => 'string', // Could use Enum if preferred, but string with validation in Request is fine
    ];

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
