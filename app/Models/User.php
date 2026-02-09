<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'password',
        'email',
        'nama_lengkap',
        'nomor_identitas',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relasi ke Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relasi ke Peminjaman
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }

    // Relasi ke Activity Log
    public function activityLogs()
    {
        return $this->hasMany(Aktivitas::class);
    }

    // Relasi ke Pengembalian yang diterima
    public function pengembaliansDiterima()
    {
        return $this->hasMany(Pengembalian::class, 'diterima_oleh');
    }

    // Helper methods untuk check role
    public function isAdmin()
    {
        return $this->role_id === Role::ADMIN;
    }

    public function isPetugas()
    {
        return $this->role_id === Role::PETUGAS;
    }

    public function isSiswa()
    {
        return $this->role_id === Role::SISWA;
    }

    // Scope untuk filter by role
    public function scopeAdmin($query)
    {
        return $query->where('role_id', Role::ADMIN);
    }

    public function scopePetugas($query)
    {
        return $query->where('role_id', Role::PETUGAS);
    }

    public function scopeSiswa($query)
    {
        return $query->where('role_id', Role::SISWA);
    }
}