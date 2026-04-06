<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\Property;
use App\Models\Booking;
use App\Models\Lead;
use App\Enums\UserRole;
use App\Enums\PropertyStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_create_booking_and_lead()
    {
        $agent = User::factory()->create(['role' => UserRole::AGENT]);
        $customer = User::factory()->create(['role' => UserRole::CUSTOMER]);
        $property = Property::factory()->create([
            'owner_id' => $agent->id,
            'status' => PropertyStatus::ACTIVE
        ]);

        $response = $this->actingAs($customer)
                         ->postJson('/api/v1/bookings', [
                             'property_id' => $property->id,
                             'scheduled_at' => now()->addDays(2)->toDateTimeString(),
                         ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('bookings', ['customer_id' => $customer->id, 'property_id' => $property->id]);
        $this->assertDatabaseHas('leads', ['customer_id' => $customer->id, 'property_id' => $property->id]);
    }

    public function test_agent_can_confirm_booking()
    {
        $agent = User::factory()->create(['role' => UserRole::AGENT]);
        $customer = User::factory()->create(['role' => UserRole::CUSTOMER]);
        $property = Property::factory()->create(['owner_id' => $agent->id]);
        $booking = Booking::factory()->create([
            'property_id' => $property->id,
            'customer_id' => $customer->id,
            'agent_id' => $agent->id,
            'status' => 'pending'
        ]);

        $response = $this->actingAs($agent)
                         ->patchJson("/api/v1/bookings/{$booking->uuid}", [
                             'status' => 'confirmed'
                         ]);

        $response->assertStatus(200);
        $this->assertEquals('confirmed', $booking->fresh()->status);
    }
}
