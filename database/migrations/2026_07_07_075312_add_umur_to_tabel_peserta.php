<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tabel_peserta', function (Blueprint $table) {
            $table->integer('umur')->nullable()->after('nama');
            // $table->string()->nullable()->after('telepon'); // Dihapus karena redundant
        });
    }

    public function down(): void
    {
        Schema::table('tabel_peserta', function (Blueprint $table) {
            $table->dropColumn(['umur', ]);
        });
    }
};