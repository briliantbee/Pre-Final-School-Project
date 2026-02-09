<?php

namespace App\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SiswaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isSiswa()) {
            abort(403, 'Akses ditolak. Hanya siswa yang diizinkan.');
        }

        return $next($request);
    }
}