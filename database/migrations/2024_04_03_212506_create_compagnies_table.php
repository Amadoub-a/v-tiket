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
        Schema::create('compagnies', function (Blueprint $table) {
            $table->id();
            $table->string('raison_sociale')->unique();
            $table->string('contact')->unique();
            $table->string('email')->unique();
            $table->string('adresse');
            $table->string('contact_fixe')->nullable();
            $table->foreignId('country_id')->index();
            $table->integer('annee_fondation')->nullable();
            $table->string('site_internet')->nullable();

            $table->foreignId('created_by')->nullable()->index();
            $table->foreignId('updated_by')->nullable()->index();
            $table->foreignId('deleted_by')->nullable()->index();
            $table->timestamp('deleted_at')->nullable();
            
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compagnies');
    }
};
