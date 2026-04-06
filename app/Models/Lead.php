<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\LeadStatus;

class Lead extends Model {
    use SoftDeletes, HasFactory;

    protected $fillable = ['property_id', 'customer_id', 'status', 'notes'];

    protected $casts = [
        'status' => LeadStatus::class,
    ];

    public function property(): BelongsTo {
        return $this->belongsTo(Property::class);
    }

    public function customer(): BelongsTo {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
