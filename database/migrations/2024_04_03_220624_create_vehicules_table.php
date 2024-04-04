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
        Schema::create('vehicules', function (Blueprint $table) {
            $table->id();
            $table->string('immatriculation')->unique();
            $table->string('numero_chassis')->unique();
            $table->integer('nombre_place');
            $table->integer('annee_fabrication');
            $table->foreignId('marque_id')->index();
            $table->foreignId('genre_id')->index();
            $table->foreignId('modele_id')->index();
            $table->foreignId('compagnie_id')->index();

            $table->foreignId('created_by')->nullable()->index();
            $table->foreignId('updated_by')->nullable()->index();
            $table->foreignId('deleted_by')->nullable()->index();
            $table->timestamp('deleted_at')->nullable();
            
            $table->timestamps();

            $table->foreign('marque_id')->references('id')->on('marques')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('modele_id')->references('id')->on('modeles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('compagnie_id')->references('id')->on('compagnies')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicules');
    }
};
