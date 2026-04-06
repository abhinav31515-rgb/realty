<?php
namespace App\Models;

use App\Enums\PropertyStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Property extends Model {
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'uuid', 'owner_id', 'title', 'description', 'type', 'location', 
        'price', 'images', 'status', 'metadata', 'is_featured', 
        'listing_category', 'bhk_count', 'total_area', 
        'furnishing_status', 'possession_status', 'posted_by', 
        'tags', 'views_count', 'clicks_count'
    ];

    protected $casts = [
        'images' => 'array',
        'metadata' => 'array',
        'is_featured' => 'boolean',
        'status' => PropertyStatus::class,
        'price' => 'decimal:2',
        'total_area' => 'decimal:2',
    ];

    protected static function booted() {
        static::creating(function ($property) {
            if (!$property->uuid) $property->uuid = (string) Str::uuid();
        });
    }

    public function getRouteKeyName() {
        return 'uuid';
    }

    public function scopeActive(Builder $query): Builder {
        return $query->where('status', PropertyStatus::ACTIVE);
    }

    public function scopeFeatured(Builder $query): Builder {
        return $query->where('is_featured', true);
    }

    public function scopeFilterByCategory(Builder $query, ?string $category): Builder {
        return $category ? $query->where('listing_category', $category) : $query;
    }

    public function owner(): BelongsTo {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function bookings(): HasMany {
        return $this->hasMany(Booking::class);
    }
}
