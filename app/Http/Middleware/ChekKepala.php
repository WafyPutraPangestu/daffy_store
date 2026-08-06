<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ChekKepala
{
    /**
     * Handle an incoming request.
     * Hanya mengizinkan user dengan role 'kepala' untuk melewati middleware ini.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Gate::denies('kepala')) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Kepala.');
        }

        return $next($request);
    }
}
