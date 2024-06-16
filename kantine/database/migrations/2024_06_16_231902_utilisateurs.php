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
        Schema::create('utilisateurs', function (Blueprint $table) {
        $table->id();
        $table->string('code');
        $table->string('nomComplet');
        $table->string('photo');
        $table->string('numero1')->unique();
        $table->string('numero2')->nullable();
        $table->char('genre');
        $table->string('profession')->nullable();
        $table->string('email')->unique();  
        $table->string('motDePasse');
        $table->foreignId('roleID')->constrained('roles');
        $table->boolean('active')->default(1);
        $table->boolean('deleted')->default(0);
        $table->timestamps();       
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};
