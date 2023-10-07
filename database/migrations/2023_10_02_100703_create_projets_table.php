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
        Schema::create('projets', function (Blueprint $table) {
            $table->id();
            $table->string('libelle', 42);
            $table->string('statut', 42);
            $table->float('taux_horaire', 5, 2);

            $table->unsignedBigInteger('id_domaine');
            $table->unsignedBigInteger('id_chef_projet');
            $table->unsignedBigInteger('id_client');
            
            $table->foreign('id_domaine')->references('id')->on('domaines');
            $table->foreign('id_chef_projet')->references('id')->on('intervenants');
            $table->foreign('id_client')->references('id')->on('clients');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projets');
    }
};
