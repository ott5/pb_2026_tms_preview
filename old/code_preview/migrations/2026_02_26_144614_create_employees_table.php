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
        Schema::create('employees', function (Blueprint $table) {
            $table->mediumIncrements('id');
            //Pierwsze imię pracownika
            $table->string('first_name',255)
                ->comment("First name of the employee");
            //Drugie imię pracownika
            $table->string('second_name',255)
                ->nullable()
                ->comment("Second name of the employee");
            //Nazwisko Pracownika
            $table->string('last_name',255)
                ->comment("Last name of the employee");
            //Unikalny identyfikator firmowy
            $table->string('employee_number',30)
                ->unique()
                ->comment("Unique employee number in the company");
            //Referencja do konta użytkownika
            $table->unsignedMediumInteger('user_id')
                ->unique()
                ->nullable()
                ->comment("Referency to user account users(id)");
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onUpdate('cascade')
            ->onDelete('set null');
            //Czy pracownik pracuje (czy jest dostepny np.Nie ma urlopu)
            $table->boolean('is_active')
                ->default(true)
                ->comment("If the empoyee is not working flag is false");
            $table->timestamps();
        });
        //Tabla głowna pracowników
        DB::statement("ALTER TABLE employees COMMENT 'Main employees table'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
