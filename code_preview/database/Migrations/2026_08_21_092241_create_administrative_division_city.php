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
        Schema::create('administrative_division_city', function (Blueprint $table) {
            $table->id();
            $table->foreignId('administrative_division_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('city_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->unique(['administrative_division_id', 'city_id'], 'administrative_division_city_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrative_division_city');
    }
};
