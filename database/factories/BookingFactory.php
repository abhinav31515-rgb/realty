<?php
namespace Database\Factories;
use App\Models\Booking;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookingFactory extends Factory {
    protected $model = Booking::class;
    public function definition(): array {
        return [
            'uuid' => (string) Str::uuid(),
            'property_id' => Property::factory(),
            'customer_id' => User::factory(),
            'agent_id' => User::factory(),
            'scheduled_at' => now()->addDays(2),
            'status' => 'pending',
        ];
    }
}
