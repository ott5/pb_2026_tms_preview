<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->mediumIncrements('id');
            //Referencja do kodów pocztowych
            $table->unsignedInteger('postal_code_id')
                ->nullable()
                ->comment('Reference to postal_codes(id)');
            $table->foreign('postal_code_id')
                ->references('id')
                ->on('postal_codes')
                ->onUpdate('cascade')
                ->onDelete('set null');
            //Nazwa ulicy
            $table->string('street',255)
                ->nullable()
                ->comment('Street name (e.g. Mickiewicza, Sienkiewicza');            
            //Numer budynku
            $table->string('building_number',15)
            ->comment('Building number (e.g. 5A, 8');
            //Numer mieszkania lub lokalu
            $table->string('apartment_number',15)
                ->nullable()
                ->comment('Apartment number (e.g 5, 4A');
            $table->timestamps();
        });
        // Głowna tabela przechowujaca fizyczne adresy wraz z odnośnikami kodów pocztowych
        DB::statement("ALTER TABLE addresses COMMENT 'Main table for physical addresses with dictionary links'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
