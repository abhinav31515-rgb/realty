<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Booking extends Model {
    use HasFactory;
    protected $fillable = ['property_id', 'customer_id', 'agent_id', 'status', 'scheduled_at'];
    protected $casts = ['scheduled_at' => 'datetime'];
    public function property() { return $this->belongsTo(Property::class); }
    public function customer() { return $this->belongsTo(User::class, 'customer_id'); }
    public function agent() { return $this->belongsTo(User::class, 'agent_id'); }
}
