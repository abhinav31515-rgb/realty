<?php
namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'profile_data', 'is_verified', 'saved_searches'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'profile_data' => 'array',
        'saved_searches' => 'array',
        'role' => UserRole::class,
        'is_verified' => 'boolean',
    ];

    public function properties(): HasMany {
        return $this->hasMany(Property::class, 'owner_id');
    }

    public function bookings(): HasMany {
        return $this->hasMany(Booking::class, 'customer_id');
    }

    public function agentBookings(): HasMany {
        return $this->hasMany(Booking::class, 'agent_id');
    }

    public function favorites(): HasMany {
        return $this->hasMany(Favorite::class);
    }
}
