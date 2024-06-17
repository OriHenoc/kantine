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
        Schema::create('ligne', function (Blueprint $table) {
            $table->id();
            $table->string('statut');
            $table->foreignId('commandeID')->constrained('commandes');
            $table->boolean('active')->default(1);
            $table->boolean('deleted')->default(0);
            $table->foreignId('utilisateurID')->constrained('utilisateurs');
            $table->timestamps();
            $table->foreignId('createdBy')->constrained('utilisateurs');
            $table->foreignId('updatedBy')->constrained('utilisateurs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ligne_de_commandes');
    }
};
