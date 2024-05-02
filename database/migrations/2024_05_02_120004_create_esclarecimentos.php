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
        Schema::create('esclarecimentos', function (Blueprint $table) {
            $table->id();
            $table->string('esclarecimento',255);
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('denuncias_id');
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('denuncias_id')->references('id')->on('denuncias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esclarecimentos');
    }
};
