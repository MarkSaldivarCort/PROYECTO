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
        Schema::create('auditoria_exportaciones', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->string('nombre_usuario');
            $table->string('tipo_usuario');
            $table->string('ip', 45)->nullable();

            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditoria_exportaciones');
    }
};
