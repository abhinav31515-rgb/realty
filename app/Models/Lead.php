<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'property_id',
        'customer_id',
        'status',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'status' => \App\Enums\LeadStatus::class,
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
