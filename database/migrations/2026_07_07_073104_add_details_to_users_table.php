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
    Schema::table('tabel_users', function (Blueprint $table) {
        // Cek jika kolom no_telp BELUM ada, maka buat
        if (!Schema::hasColumn('tabel_users', 'no_telp')) {
            $table->string('no_telp')->nullable()->after('email');
        }
        
        // Cek jika kolom alamat BELUM ada, maka buat
        if (!Schema::hasColumn('tabel_users', 'alamat')) {
            $table->text('alamat')->nullable()->after('no_telp');
        }
    });
}

public function down(): void
{
    Schema::table('tabel_users', function (Blueprint $table) {
        if (Schema::hasColumn('tabel_users', 'no_telp')) {
            $table->dropColumn('no_telp');
        }
        
        if (Schema::hasColumn('tabel_users', 'alamat')) {
            $table->dropColumn('alamat');
        }
    });
}
};
