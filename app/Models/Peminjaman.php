<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Peminjaman extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    // Explicit table name to avoid incorrect pluralization
    protected $table = 'peminjamans';

    protected $casts = [
        'tanggal_peminjaman' => 'date',
        'tanggal_berakhir_peminjaman' => 'date',
        'tanggal_disetujui' => 'datetime',
    ];

    // Relasi ke User (peminjam)
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Alat
    public function alat() {
        return $this->belongsTo(Alat::class);
    }

    // Relasi ke User yang menyetujui
    public function disetujuiOleh() {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }

    // Relasi ke Pengembalian
    public function pengembalian() {
        return $this->hasOne(Pengembalian::class);
    }

    public function scopeMenungguKonfirmasi($query) {
        return $query->where('status', 'menunggu_konfirmasi');
    }

    public function scopeDisetujui($query) {
        return $query->where('status', 'disetujui');
    }

    public function scopeDitolak($query) {
        return $query->where('status', 'ditolak');
    }

    public function scopeDipinjam($query) {
        return $query->where('status', 'dipinjam');
    }

    public function scopeDikembalikan($query) {
        return $query->where('status', 'dikembalikan');
    }

    public function scopeMelewatiJadwal($query) {
        return $query->where('status', 'melewati_jadwal');
    }

    public function isTerlambat() { 
        return Carbon::now()->isAfter($this->tanggal_berakhir_peminjaman) 
        && in_array($this->status, ['dipinjam', 'melewati_jadwal']);
    }

     public function getHariTerlambatAttribute()
    {
        if (!$this->isTerlambat()) {
            return 0;
        }
        
        return Carbon::now()->diffInDays($this->tanggal_berakhir_peminjaman);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'menunggu_konfirmasi' => 'warning',
            'disetujui' => 'info',
            'ditolak' => 'danger',
            'dipinjam' => 'primary',
            'dikembalikan' => 'success',
            'melewati_jadwal' => 'danger',
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    protected static function boot() {
        parent::boot();

        static::creating(function ($peminjaman) {
         if (empty($peminjaman->kode_peminjaman)) {
            $peminjaman->kode_peminjaman = 'PJM-' . date('Ymd') . '-' . str_pad(
            Peminjaman::whereDate('created_at', today())->count() + 1,
            4,
            '0',
            STR_PAD_LEFT
            );
            }
        });
    }
}
