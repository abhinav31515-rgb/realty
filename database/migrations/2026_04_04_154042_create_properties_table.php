<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('type');
            $table->string('location');
            $table->decimal('price', 15, 2);
            $table->json('images')->nullable();
            $table->string('status')->default('active');
            $table->jsonb('metadata')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            $table->index(['location', 'price', 'type']);
        });
    }
    public function down(): void { Schema::dropIfExists('properties'); }
};
