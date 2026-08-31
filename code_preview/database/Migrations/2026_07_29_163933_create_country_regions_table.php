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
        Schema::create('country_regions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            //ISO 3166-2 region code (without country prefix)
            $table->string('code',3);
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->unique(['name','code','country_id']) ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('country_regions');
    }
};
