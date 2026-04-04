<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserRoleSeeder extends Seeder {
    public function run(): void {
        User::create(['name' => 'Admin User', 'email' => 'admin@luxeestate.com', 'password' => Hash::make('password'), 'role' => 'admin']);
        User::create(['name' => 'Marcus Chen', 'email' => 'marcus@luxeestate.com', 'password' => Hash::make('password'), 'role' => 'agent']);
        User::create(['name' => 'Julian', 'email' => 'julian@example.com', 'password' => Hash::make('password'), 'role' => 'customer']);
    }
}
