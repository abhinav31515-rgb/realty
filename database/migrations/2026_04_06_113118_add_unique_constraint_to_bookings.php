<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('bookings', function (Blueprint $table) {
            // Prevent duplicate requests for same property by same user at same time
            $table->unique(['property_id', 'customer_id', 'scheduled_at'], 'bookings_unique_request');
        });
    }
    public function down(): void {
        Schema::table('bookings', function (Blueprint $table) { $table->dropUnique('bookings_unique_request'); });
    }
};
