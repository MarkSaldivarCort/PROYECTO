
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alertas_suricata', function (Blueprint $table) {
            $table->id();

            $table->string('src_ip')->nullable();
            $table->string('dest_ip')->nullable();
            $table->string('signature')->nullable();
            $table->integer('severity')->nullable();
            $table->string('sid')->nullable();
            $table->timestamp('fecha_evento')->nullable();
            $table->string('flow_id')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alertas_suricata');
    }
};
