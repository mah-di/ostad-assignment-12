<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();

            $table->foreignId('origin_id')
                ->constrained('stops', 'id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('destination_id')
                ->constrained('stops', 'id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->enum('status', ['up', 'down']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
