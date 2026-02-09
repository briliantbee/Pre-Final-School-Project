<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Denda extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pengembalian_id',
        'denda_keterlambatan',
        'denda_kerusakan',
        'total_denda',
        'status',
        'bukti_pembayaran',
        'tanggal_pembayaran',
        'dikonfirmasi_oleh',
    ];

    protected $casts = [
        'denda_keterlambatan' => 'integer',
        'denda_kerusakan' => 'integer',
        'total_denda' => 'integer',
        'tanggal_pembayaran' => 'datetime',
    ];

    // Konstanta untuk tarif denda
    const DENDA_PER_HARI = 5000; // Rp 5.000 per hari
    const DENDA_RUSAK = 50000; // Rp 50.000
    const DENDA_HILANG = 200000; // Rp 200.000
    const DENDA_TIDAK_LENGKAP = 25000; // Rp 25.000

    // Relasi ke Pengembalian
    public function pengembalian()
    {
        return $this->belongsTo(Pengembalian::class);
    }

    // Relasi ke User (yang mengkonfirmasi)
    public function pengkonfirmasi()
    {
        return $this->belongsTo(User::class, 'dikonfirmasi_oleh');
    }

    // Helper untuk hitung total denda
    public static function hitungDenda($pengembalian)
    {
        $dendaKeterlambatan = 0;
        $dendaKerusakan = 0;

        // Hitung denda keterlambatan
        if ($pengembalian->terlambat) {
            $dendaKeterlambatan = $pengembalian->hari_terlambat * self::DENDA_PER_HARI;
        }

        // Hitung denda kerusakan
        switch ($pengembalian->kondisi_alat) {
            case 'rusak':
                $dendaKerusakan = self::DENDA_RUSAK;
                break;
            case 'hilang':
                $dendaKerusakan = self::DENDA_HILANG;
                break;
            case 'tidak_lengkap':
                $dendaKerusakan = self::DENDA_TIDAK_LENGKAP;
                break;
        }

        return [
            'denda_keterlambatan' => $dendaKeterlambatan,
            'denda_kerusakan' => $dendaKerusakan,
            'total_denda' => $dendaKeterlambatan + $dendaKerusakan,
        ];
    }

    // Accessor untuk format rupiah
    public function getTotalDendaFormatAttribute()
    {
        return 'Rp ' . number_format($this->total_denda, 0, ',', '.');
    }

    // Accessor untuk badge status
    public function getStatusBadgeAttribute()
    {
        return $this->status === 'sudah_dibayar' ? 'success' : 'danger';
    }

    // Accessor untuk URL bukti pembayaran
    public function getBuktiPembayaranUrlAttribute()
    {
        return $this->bukti_pembayaran ? asset('storage/' . $this->bukti_pembayaran) : null;
    }
}