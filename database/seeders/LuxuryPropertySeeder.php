<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\User;
class LuxuryPropertySeeder extends Seeder {
    public function run(): void {
        $agent = User::where('role', 'agent')->first();
        Property::create([
            'owner_id' => $agent->id,
            'title' => 'The Obsidian Sanctuary',
            'description' => 'An architectural masterpiece of glass and steel.',
            'type' => 'Villa',
            'location' => 'Beverly Hills, CA',
            'price' => 24500000.00,
            'status' => 'active',
            'is_featured' => true,
            'metadata' => ['amenities' => ['Pool', 'Gym', 'Cinema'], 'smart_features' => true]
        ]);
        Property::create([
            'owner_id' => $agent->id,
            'title' => 'The Zenith Penthouse',
            'description' => 'Sky-high luxury with 360-degree views.',
            'type' => 'Penthouse',
            'location' => 'New York, NY',
            'price' => 18200000.00,
            'status' => 'active',
            'is_featured' => true,
        ]);
    }
}
