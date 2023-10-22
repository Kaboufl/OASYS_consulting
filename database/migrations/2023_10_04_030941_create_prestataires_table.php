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
        Schema::create('prestataires', function (Blueprint $table) {
            $table->id();
            $table->string('siret', 14);
            $table->string('raison_sociale', 255);
            $table->string('nom', 255);
            $table->string('adresse', 255);
            $table->string('code_postal', 5);
            $table->string('ville', 255);
            $table->float('taux_horaire', 7, 2);
            $table->unsignedBigInteger('id_intervenant');

            $table->timestamps();

            $table->foreign('id_intervenant')->references('id')->on('intervenants');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestataires');
    }
};
