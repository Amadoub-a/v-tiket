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
