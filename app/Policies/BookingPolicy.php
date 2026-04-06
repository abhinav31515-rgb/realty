<?php
namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use App\Enums\UserRole;

class BookingPolicy {
    public function view(User $user, Booking $booking): bool {
        return $user->id === $booking->customer_id || $user->id === $booking->agent_id || $user->role === UserRole::ADMIN;
    }

    public function update(User $user, Booking $booking): bool {
        // Customers can only cancel, agents/admins can confirm
        return $user->id === $booking->customer_id || $user->id === $booking->agent_id || $user->role === UserRole::ADMIN;
    }
}
