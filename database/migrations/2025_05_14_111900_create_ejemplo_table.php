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
        Schema::create('ejemplo', function (Blueprint $table) {
            $table->id();
            $table->string('contenido_video');
            $table->string('contenido_texto');
            $table->string('contenido_audio');
            $table->string('contenido_imagen');
            $table->unsignedBigInteger('tema_id');
            $table->foreign('tema_id')->references('id')->on('tema')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ejemplo');
    }
};
