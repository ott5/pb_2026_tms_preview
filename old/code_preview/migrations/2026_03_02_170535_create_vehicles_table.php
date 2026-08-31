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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->mediumIncrements('id');
            //Numer rejestracyjny pojazdu
            $table->string('registration_number',16)
                ->unique()
                ->nullable()
                ->comment('Registration vehicle number (e.g GXH 325D, PXA2DS');
            //Referencja do typu własciciela pojazdu
            $table->unsignedTinyInteger('owner_type_id')
                ->comment("Reference to vehicle_owner_types(id)");
            $table->foreign('owner_type_id')
                ->references('id')
                ->on('vehicle_owner_types')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            //Numer vin pojazdu
            $table->string('vin',17)
                ->unique()
                ->nullable()
                ->comment("Vehicle vin number");
            //Przebieg pojazdu
            $table->unsignedInteger('mileage')
                ->comment("Vehicle mileage");
            //Referencja do modelu i marki (poprzez model)
            $table->unsignedSmallInteger('model_id')
                ->comment("Reference to vehicle_models(id)");
            $table->foreign('model_id')
                ->references('id')
                ->on('vehicle_models')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            //Rok produkcji pojazdu
            $table->year('production_year')
                ->comment("Vehicle production year (e.g 2017)");
            //Referencja do rodzaju konfiguracji osi
            $table->unsignedTinyInteger('axle_configuration_type_id')
                ->comment("Reference to axle_configuration_types(id)");
            $table->foreign('axle_configuration_type_id')
                ->references('id')
                ->on('vehicle_axle_configuration_types')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            //Czy pojazd jest aktywnie używany w firmie (false gdy np został sprzedany/zezłomowany)
            $table->boolean('is_active')
                ->default(true)
                ->comment("Vehicle is active using in company");
            $table->timestamps();
        });
        //Główna tabela pojazdów
        DB::statement("ALTER TABLE vehicles COMMENT 'Main vehicle table'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
