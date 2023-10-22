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
        Schema::create('etapes', function (Blueprint $table) {
            $table->id();
            $table->string('libelle', 42);
            $table->unsignedBigInteger('id_projet');
            $table->unsignedBigInteger('id_facture')->nullable();
            $table->timestamps();

            $table->foreign('id_facture')->references('id')->on('factures');
            $table->foreign('id_projet')->references('id')->on('projets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etapes');
    }
};
