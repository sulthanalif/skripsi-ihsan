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
        Schema::table('documents', function (Blueprint $table) {
            $table->string('surat_pengantar_rt')->nullable();
            $table->string('surat_pengantar_rw')->nullable();
            $table->string('kk')->nullable();
            $table->string('ktp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('surat_pengantar_rt');
            $table->dropColumn('surat_pengantar_rw');
            $table->dropColumn('kk');
            $table->dropColumn('ktp');
        });
    }
};
