<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengembalian extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'peminjaman_id',
        'tanggal_pengembalian',
        'jumlah_dikembalikan',
        'kondisi_alat',
        'diterima_oleh',
        'terlambat',
        'hari_terlambat',
        'catatan',
    ];

    protected $casts = [
        'tanggal_pengembalian' => 'date',
        'terlambat' => 'boolean',
        'hari_terlambat' => 'integer',
        'jumlah_dikembalikan' => 'integer',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function penerima()
    {
        return $this->belongsTo(User::class, 'diterima_oleh');
    }

    // Alias untuk konsistensi penamaan
    public function diterimaDosen()
    {
        return $this->belongsTo(User::class, 'diterima_oleh');
    }

    public function denda()
    {
        return $this->hasOne(Denda::class);
    }

    public function getKondisiBadgeAttribute()
    {
        $badges = [
            'baik' => 'success',
            'rusak' => 'warning',
            'hilang' => 'danger',
            'tidak_lengkap' => 'warning',
        ];

        return $badges[$this->kondisi_alat] ?? 'secondary';
    }
}