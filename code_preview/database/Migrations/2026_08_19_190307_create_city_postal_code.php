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
        Schema::create('city_postal_code', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('postal_code_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->unique(['city_id', 'postal_code_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('city_postal_code');
    }
};
