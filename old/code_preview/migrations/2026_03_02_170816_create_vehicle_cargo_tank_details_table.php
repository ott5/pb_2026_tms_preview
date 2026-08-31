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
        Schema::create('vehicle_cargo_tank_details', function (Blueprint $table) {
            $table->mediumIncrements('id');
            //Referencja do pojazdów - klucz główny
            $table->unsignedMediumInteger('vehicle_id')
                ->comment("Reference to vehicles(id)");
            $table->foreign('vehicle_id')
                ->references('id')
                ->on('vehicles')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            //Referencja do rodzaju zabudowy cysterny
            $table->unsignedTinyInteger('tank_type_id')
                ->comment("Reference to vehicle_tank_types(id)");
            $table->foreign('tank_type_id')
                ->references('id')
                ->on('vehicle_tank_types')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->unsignedTinyInteger('pressure_class_id')
                ->comment("Reference to vehicle_tank_pressure_types(id)");
            //Rodzaj klasy ciśnienia w cysternie
            $table->foreign('pressure_class_id')
                ->references('id')
                ->on('vehicle_tank_pressure_types')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            //Rodzaj izolacji termicznej cystery
            $table->unsignedTinyInteger('thermal_protection_id')
                ->comment("Reference to vehicle_thermal_protection_types(id)");
            $table->foreign('thermal_protection_id')
                ->references('id')
                ->on('vehicle_thermal_protection_types')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            //Rodzaj rozładunku cysterny
            $table->unsignedTinyInteger('discharge_method_id')
                ->comment("Reference to vehicle_tank_discharge_methods(id)");
            $table->foreign('discharge_method_id')
                ->references('id')
                ->on('vehicle_tank_discharge_methods')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            //Rodzaj materiału cysterny
            $table->unsignedTinyInteger('material_id')
                ->comment("Reference to vehicle_body_materials(id)");
            $table->foreign('material_id')
                ->references('id')
                ->on('vehicle_body_materials')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            //Czy cysterna jest przystosowana do przewozu materiałów niebezpiecznych
            $table->boolean('is_adr')
                ->default(false)
                ->comment("Indicates if the tank is suitable for transporting hazardous materials (ADR)");
            //Kod ADR - jeśli cysterna jest przystosowana do przewozu materiałów niebezpiecznych, określa kod ADR zgodnie z klasyfikacją UN
            $table->unsignedTinyInteger('adr_id')
                ->nullable()
                ->comment("ADR code for the tank");
            $table->foreign('adr_id')
                ->references('id')
                ->on('vehicle_adr_types')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            //Liczba komór w cysternie
            $table->unsignedTinyInteger('compartment_count')
                ->comment("Number of compartments in the tank");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_cargo_tank_details');
    }
};
