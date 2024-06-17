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
        Schema::create('employes', function (Blueprint $table) {
            $table->id();
            $table->string('nomComplet');
            $table->text('description')->nullable();
            $table->string('numero1')->unique();
            $table->string('numero2')->unique()->nullable();
            $table->char('genre');
            $table->foreignId('posteEmployesID')->constrained('poste_employes');
            $table->string('email')->unique(); 
            $table->timestamps();       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employes');
        
    }
};
