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
        Schema::create('administrative_divisions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->foreignId('country_region_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('type')->default('other');
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('administrative_divisions')
                ->cascadeOnDelete();
            $table->unique(['name', 'country_region_id', 'type', 'parent_id'], 'unique_administrative_division');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrative_divisions');
    }
};
