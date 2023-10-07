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
        Schema::create('intervenants', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 42);
            $table->string('prenom', 42);
            $table->string('email', 42);
            $table->string('password', 255);
            $table->boolean('prestataire');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intervenants');
    }
};
