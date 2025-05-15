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
        Schema::create('curso', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('descripcion');
            $table->string('imagen');
            $table->decimal('precio', 8, 2);
            $table->decimal('descuento', 8, 2);
            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('docente_id');
            $table->foreign('categoria_id')->references('id')->on('categoria')->onDelete('cascade');
            $table->foreign('docente_id')->references('id')->on('docentes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curso');
    }
};
