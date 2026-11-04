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
        Schema::table('alertas_suricata', function (Blueprint $table) {
            $table->string('event_type')->nullable();
            $table->string('http_method')->nullable();
            $table->text('http_url')->nullable();
            $table->unsignedSmallInteger('http_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alertas_suricata', function (Blueprint $table) {
            $table->dropColumn([
                'event_type',
                'http_method',
                'http_url',
                'http_status',
            ]);
        });
    }
};
