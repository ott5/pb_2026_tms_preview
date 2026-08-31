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
        Schema::create('employee_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('address_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('type')
                ->default('');
            $table->unique(['employee_id', 'address_id', 'type'], 'unique_employee_address');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_addresses');
    }
};
