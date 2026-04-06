<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_always_defaults_to_customer_role()
    {
        $response = $this->postJson('/api/v1/register', [
            'name' => 'Attacker',
            'email' => 'attacker@example.com',
            'password' => 'password123',
            'role' => 'admin' // Attempted privilege escalation
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'email' => 'attacker@example.com',
            'role' => UserRole::CUSTOMER
        ]);
        
        $user = User::where('email', 'attacker@example.com')->first();
        $this->assertEquals(UserRole::CUSTOMER, $user->role);
    }
}
