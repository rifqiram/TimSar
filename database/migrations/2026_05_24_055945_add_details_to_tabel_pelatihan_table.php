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
        Schema::table('tabel_pelatihan', function (Blueprint $table) {
            // $table->string('kategori')->nullable()->after('deskripsi'); // Dihapus karena redundan dengan tabel_kategori
            $table->string('level')->nullable()->after('deskripsi');
            $table->string('durasi')->nullable()->after('level');
            $table->string('sertifikat')->nullable()->after('durasi');
            // $table->string('status')->default('Aktif')->after('is_active'); // Dihapus karena redundan dengan is_active boolean
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tabel_pelatihan', function (Blueprint $table) {
            $table->dropColumn(['level', 'durasi', 'sertifikat', ]);
        });
    }
};
