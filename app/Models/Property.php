<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model {
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'owner_id', 'title', 'description', 'type', 'location', 
        'price', 'images', 'status', 'metadata', 'is_featured', 
        'listing_category', 'bhk_count', 'total_area', 
        'furnishing_status', 'possession_status', 'posted_by', 
        'tags', 'views_count', 'clicks_count'
    ];

    protected $casts = [
        'images' => 'array',
        'metadata' => 'array',
        'is_featured' => 'boolean',
        'status' => \App\Enums\PropertyStatus::class,
        'price' => 'decimal:2',
        'total_area' => 'decimal:2',
    ];

    public function scopeActive(Builder $query): Builder {
        return $query->where('status', 'active');
    }

    public function scopeFeatured(Builder $query): Builder {
        return $query->where('is_featured', true);
    }

    public function scopeFilterByCategory(Builder $query, ?string $category): Builder {
        return $category ? $query->where('listing_category', $category) : $query;
    }

    public function owner(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function bookings(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Booking::class);
    }
}
