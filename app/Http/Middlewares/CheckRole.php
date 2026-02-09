<?php

namespace App\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $userRole = $user->role->nama_role ?? null;

        if (!$userRole) {
            abort(403, 'Unauthorized action.');
        }

        // normalize role string: lowercase, remove spaces/underscores
        $normalize = function ($r) {
            $r = strtolower(trim((string) $r));
            $r = str_replace([' ', '_'], '', $r);
            if ($r === 'siswa') {
                return 'peminjam';
            }
            if ($r === 'petugaspeminjaman' || $r === 'petugas') {
                return 'petugas';
            }
            return $r;
        };

        $current = $normalize($userRole);

        // if no specific roles were provided, allow any authenticated user
        if (empty($roles)) {
            return $next($request);
        }

        $allowed = array_map($normalize, $roles);

        if (!in_array($current, $allowed, true)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}