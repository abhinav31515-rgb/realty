<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('listing_category')->default('buy'); // buy, rent, commercial
            $table->integer('bhk_count')->nullable();
            $table->decimal('total_area', 12, 2)->nullable();
            $table->string('furnishing_status')->nullable(); // furnished, semi-furnished, unfurnished
            $table->string('possession_status')->nullable(); // ready to move, under construction
            $table->string('posted_by')->default('agent'); // owner, builder, agent
            $table->json('tags')->nullable();
            $table->integer('views_count')->default(0);
            $table->integer('clicks_count')->default(0);
        });
    }
    public function down(): void {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['listing_category', 'bhk_count', 'total_area', 'furnishing_status', 'possession_status', 'posted_by', 'tags', 'views_count', 'clicks_count']);
        });
    }
};
