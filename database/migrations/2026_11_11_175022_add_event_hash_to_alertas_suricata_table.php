<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alertas_suricata', function (Blueprint $table) {
            $table->char('event_hash', 64)->nullable()->unique();
        });
    }

    public function down(): void
    {
        Schema::table('alertas_suricata', function (Blueprint $table) {
            $table->dropUnique(['event_hash']);
            $table->dropColumn('event_hash');
        });
    }
};
