<?php

use App\Models\Compagnie;
use App\Models\Ville;
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
        Schema::create('compagnie_ville', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Compagnie::class);
            $table->foreignIdFor(Ville::class);

            $table->foreign('compagnie_id')->references('id')->on('compagnies')->onDelete('cascade');
            $table->foreign('ville_id')->references('id')->on('villes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compagnie_ville');
    }
};
