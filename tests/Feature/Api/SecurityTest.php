<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\Property;
use App\Enums\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_cannot_delete_property()
    {
        $customer = User::factory()->create(['role' => UserRole::CUSTOMER]);
        $property = Property::factory()->create();

        $response = $this->actingAs($customer)
                         ->deleteJson("/api/v1/properties/{$property->uuid}");

        $response->assertStatus(403);
    }

    public function test_agent_cannot_delete_others_property()
    {
        $agent1 = User::factory()->create(['role' => UserRole::AGENT]);
        $agent2 = User::factory()->create(['role' => UserRole::AGENT]);
        $property = Property::factory()->create(['owner_id' => $agent1->id]);

        $response = $this->actingAs($agent2)
                         ->deleteJson("/api/v1/properties/{$property->uuid}");

        $response->assertStatus(403);
    }

    public function test_admin_can_delete_any_property()
    {
        $admin = User::factory()->create(['role' => UserRole::ADMIN]);
        $property = Property::factory()->create();

        $response = $this->actingAs($admin)
                         ->deleteJson("/api/v1/properties/{$property->uuid}");

        $response->assertStatus(200);
        $this->assertSoftDeleted('properties', ['id' => $property->id]);
    }
}
