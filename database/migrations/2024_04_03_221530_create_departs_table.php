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
        Schema::create('departs', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_depart');
            $table->dateTime('date_arrivee');
            $table->integer('place_occupee');
            $table->foreignId('vehicule_id');
            $table->foreignId('chauffeur_id')->index();
            $table->foreignId('ville_depart_id');
            $table->foreignId('ville_arrivee_id');
            $table->foreignId('passager_id')->index(); //client ou passager dans la table users
            
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->foreignId('deleted_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            
            $table->timestamps();

            $table->foreign('vehicule_id')->references('id')->on('vehicules')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('chauffeur_id')->references('id')->on('chauffeurs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('ville_depart_id')->references('id')->on('villes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('ville_arrivee_id')->references('id')->on('villes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('passager_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
     
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departs');
    }
};
