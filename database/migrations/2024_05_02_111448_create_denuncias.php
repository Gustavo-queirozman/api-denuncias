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
        Schema::create('denuncias', function (Blueprint $table) {
            $table->id();
            $table->string('nome',255);
            $table->string('funcao', 255);
            $table->string('email',256);
            $table->string('telefone',255);
            $table->string('descricao',255);
            $table->string('status', 50);
            $table->string('referencia_protocolo',50);
            $table->string('numero_protocolo',50);
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('tipos_relato_id');
            $table->unsignedBigInteger('locais_relato_id');
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('tipos_relato_id')->references('id')->on('tipos_relato');
            $table->foreign('locais_relato_id')->references('id')->on('locais_relato');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denuncias');
    }
};
