<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alat extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function kategori() {
        return $this->belongsTo(Kategori::class);
    }

    public function peminjamans() {
        return $this->hasMany(Peminjaman::class);
    }

    public function scopeTersedia($query) {
        return $query->where('status', 'tersedia')->where('stok_tersedia', '>', 0);
    }

    public function scopeTidakTersedia($query) {
        return $query->where('status', 'tidak_tersedia')->orWhere('stok_tersedia', '=', 0);
    }

   public function updateStokTersedia()
    {
        $dipinjam = $this->peminjamans()
            ->whereIn('status', ['disetujui', 'dipinjam'])
            ->sum('jumlah');
        
        $this->stok_tersedia = $this->stok - $dipinjam;
        $this->status = $this->stok_tersedia > 0 ? 'tersedia' : 'tidak_tersedia';
        $this->save();
    }

}
