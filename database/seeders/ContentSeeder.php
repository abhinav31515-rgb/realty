<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Content;
class ContentSeeder extends Seeder {
    public function run(): void {
        Content::create([
            'title' => 'Investing in Architecture',
            'slug' => 'investing-in-architecture',
            'body' => 'Luxury real estate is more than just square footage; it is an investment in architectural integrity...',
            'type' => 'guide'
        ]);
        Content::create([
            'title' => 'The Future of Smart Homes',
            'slug' => 'future-of-smart-homes',
            'body' => 'Integrating AI and sustainable energy into high-end residences...',
            'type' => 'blog'
        ]);
    }
}
