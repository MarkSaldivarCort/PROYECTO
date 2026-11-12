<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bloqueos_exportacion', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('usuario_id');

            $table->string('ip', 45)->nullable();

            $table->string('motivo')->nullable();

            $table->timestamp('bloqueado_hasta');

            $table->timestamps();

            $table->index('usuario_id');
            $table->index('bloqueado_hasta');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bloqueos_exportacion');
    }
};