<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aktivitas extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'aktivitas',
        'deskripsi',
        'ip_address',
        'user_agent',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper untuk log aktivitas
    public static function logActivity($aktivitas, $deskripsi = null, $userId = null)
    {
        return self::create([
            'user_id' => $userId ?? auth()->id(),
            'aktivitas' => $aktivitas,
            'deskripsi' => $deskripsi,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}