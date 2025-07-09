<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Jika role tidak sesuai
        if (auth()->user()->id_role != $role) {
            // Jika user adalah mahasiswa (role 3) mencoba akses admin
            if (auth()->user()->id_role == 3) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('admin');
            }

            // Untuk role lainnya tampilkan unauthorized
            abort(403, 'Unauthorized action.');
        }


        return $next($request);
    }
}
