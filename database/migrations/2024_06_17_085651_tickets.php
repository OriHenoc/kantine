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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('statut');
            $table->string('qrCode')->nullable();
            $table->foreignId('menuID')->constrained('menus');
            $table->integer('quantite');
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
        Schema::dropIfExists('tickets');
    }
};
