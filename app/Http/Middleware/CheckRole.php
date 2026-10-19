<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
        }

        $user = Auth::user();

        if (empty($roles) || in_array($user->role, $roles, true)) {
            return $next($request);
        }

        // If user doesn't have the appropriate role (Redirect Flow protection)
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Akses dialihkan ke Dashboard Admin.');
        }

        if ($user->role === 'peminjam') {
            return redirect()->route('peminjam.room-catalog')->with('error', 'Akses ditolak: Halaman ini hanya dapat diakses oleh Administrator.');
        }

        return redirect()->route('login')->with('error', 'Akses tidak diizinkan.');
    }
}
