<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $table = 'tabel_peserta';

    /**
     * Langkah 2: Menambahkan kolom baru ke dalam $fillable
     * Agar data 'umur' dan 'keahlian' bisa diisi (mass assignment)
     */
    protected $fillable = [
        'nama',
        'email',
        'telepon', 
        'umur',     // Menambahkan 'umur'
        'keahlian', // Menambahkan 'keahlian'
    ];

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class, 'peserta_id');
    }

    public function pelatihans()
    {
        return $this->belongsToMany(Pelatihan::class, 'tabel_pendaftaran', 'peserta_id', 'pelatihan_id')
            ->withTimestamps()
            ->withPivot(['status', 'tanggal_daftar']);
    }

    public function keahlians()
    {
        return $this->belongsToMany(Keahlian::class, 'tabel_peserta_keahlian', 'peserta_id', 'keahlian_id')
            ->withPivot('level')
            ->withTimestamps();
    }
}