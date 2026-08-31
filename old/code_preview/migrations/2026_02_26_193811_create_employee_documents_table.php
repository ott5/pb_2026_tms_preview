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
        Schema::create('employee_documents', function (Blueprint $table) {
            $table->mediumIncrements('id');
            //Referencja do pracownika
            $table->unsignedMediumInteger('employee_id')
                ->comment("Referency to employees(id)");
            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            //Referencja do rodzaju dokumentu
            $table->string('document_type_code',4)
                ->comment("Referency to document_types(code)");
            $table->foreign('document_type_code')
                ->references('code')
                ->on('document_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            //Numer dokumentu
            $table->string('number',255)
                ->comment("Document number");
            //Data wydania dokumentu
            $table->date('issue_date')
                ->comment("Document issue date");
            //Referencja do państwa wydania dokumentu
            $table->char('issue_country_tag',2)
                ->comment("Referency to document issue country tag countries(tag)");
            $table->foreign('issue_country_tag')
                ->references('tag')
                ->on('countries')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            //Data ważności dokumentu
            $table->date("expiry_date")
            ->comment("Document expiry date");
            //Referencja do pliku
            $table->unsignedMediumInteger('attachment_id')
            ->comment("Document attachment");
            $table->foreign('attachment_id')
                ->references('id')
                ->on('attachments')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            //Czy plik został zweryfikowany i czy jest aktywny
            $table->boolean('is_active')
                ->default(false)
                ->comment("The document is verified and active (true/false)");
            $table->unique(['employee_id','document_type_code','attachment_id'],'employee_documents_empl_id_doc_type_code_attach_id_unique');
            $table->timestamps();
        });
        //Tabela zawierająca informacje o dokumentach pracownika
        DB::statement("ALTER TABLE employee_documents COMMENT 'Table include employee documents'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_documents');
    }
};
