<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('bookings', function (Blueprint $table) {
            $table->index('property_id');
            $table->index('customer_id');
            $table->index('agent_id');
        });
        Schema::table('leads', function (Blueprint $table) {
            $table->index('property_id');
            $table->index('customer_id');
        });
    }
    public function down(): void {
        Schema::table('bookings', function (Blueprint $table) { $table->dropIndex(['property_id', 'customer_id', 'agent_id']); });
        Schema::table('leads', function (Blueprint $table) { $table->dropIndex(['property_id', 'customer_id']); });
    }
};
