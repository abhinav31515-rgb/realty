<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void {
        $tables = ['properties', 'bookings', 'users'];

        foreach ($tables as $table) {
            if (!Schema::hasColumn($table, 'uuid')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->uuid('uuid')->nullable()->unique()->after('id');
                });

                // Backfill UUIDs
                DB::table($table)->whereNull('uuid')->get()->each(function ($row) use ($table) {
                    DB::table($table)->where('id', $row->id)->update(['uuid' => (string) Str::uuid()]);
                });

                // Set to NOT NULL
                Schema::table($table, function (Blueprint $table) {
                    $table->uuid('uuid')->nullable(false)->change();
                });
            }
        }
    }

    public function down(): void {
        foreach (['properties', 'bookings', 'users'] as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('uuid');
            });
        }
    }
};
