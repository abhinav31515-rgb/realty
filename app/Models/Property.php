<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Property extends Model {
    use SoftDeletes;
    use HasFactory;
    protected $fillable = ['owner_id', 'title', 'description', 'type', 'location', 'price', 'images', 'status', 'metadata', 'is_featured', 'listing_category', 'bhk_count', 'total_area', 'furnishing_status', 'possession_status', 'posted_by', 'tags', 'views_count', 'clicks_count'];
    protected $casts = ['images' => 'array', 'metadata' => 'array', 'is_featured' => 'boolean'];
    public function owner() { return $this->belongsTo(User::class, 'owner_id'); }
    public function bookings() { return $this->hasMany(Booking::class); }
}
