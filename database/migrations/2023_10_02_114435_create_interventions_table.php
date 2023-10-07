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
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->string('libelle', 42);
            $table->dateTime('date_debut_intervention', $precision = 0);
            $table->dateTime('date_fin_intervention', $precision = 0);
            $table->string('commentaire', 255);

            $table->unsignedBigInteger('id_etape');
            $table->unsignedBigInteger('id_intervenant');
            $table->unsignedBigInteger('id_facture');
            $table->timestamps();

            $table->foreign('id_etape')->references('id')->on('etapes');
            $table->foreign('id_intervenant')->references('id')->on('intervenants');
            $table->foreign('id_facture')->references('id')->on('factures');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interventions');
    }
};
