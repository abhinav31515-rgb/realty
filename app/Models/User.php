<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = ['name', 'email', 'password', 'role', 'profile_data'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed', 'profile_data' => 'array'];
    public function properties() { return $this->hasMany(Property::class, 'owner_id'); }
    public function bookings() { return $this->hasMany(Booking::class, 'customer_id'); }
    public function agentBookings() { return $this->hasMany(Booking::class, 'agent_id'); }
    public function favorites() { return $this->hasMany(Favorite::class); }
}
