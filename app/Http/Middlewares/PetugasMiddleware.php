<?php

namespace App\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PetugasMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isPetugas()) {
            abort(403, 'Akses ditolak. Hanya petugas yang diizinkan.');
        }

        return $next($request);
    }
}