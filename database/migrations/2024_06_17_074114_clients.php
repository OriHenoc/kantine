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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('nomComplet');
            $table->text('description')->nullable();
            $table->string('numero1')->unique();
            $table->string('numero2')->unique()->nullable();
            $table->char('genre');
            $table->string('entreprise')->nullable();
            $table->text('image')->nullable();
            $table->foreignId('groupeDeClientID')->constrained('groupe_de_clients');
            $table->string('email')->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('deleted')->default(0);
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
        Schema::dropIfExists('clients');

    }
};
