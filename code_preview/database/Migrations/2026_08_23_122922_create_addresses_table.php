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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_postal_code_id')
                ->constrained('city_postal_code')
                ->cascadeOnDelete();
            $table->string('street')
                ->nullable();
            $table->string('building_number');
            $table->string('apartment_number')
                ->nullable();
            $table->unique(['city_postal_code_id', 'street', 'building_number', 'apartment_number'], 'unique_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
