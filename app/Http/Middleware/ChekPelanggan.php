<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ChekPelanggan
{
    /**
     * Handle an incoming request.
     * Hanya mengizinkan user dengan role 'pelanggan' untuk melewati middleware ini.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Gate::denies('pelanggan')) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Pelanggan.');
        }

        return $next($request);
    }
}
