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
        Schema::create('groupe_de_clients', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('libelle');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('groupe_de_clients');

    }
};