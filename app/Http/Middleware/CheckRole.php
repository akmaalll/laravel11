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
     * @param  string $roles Comma-separated roles, e.g., "1,2,3"
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Bersihkan dan konversi semua ke integer
        $allowedRoles = array_map('intval', array_map('trim', explode('|', $roles)));
        
        // Ambil role user sebagai integer
        $userRole = (int) auth()->user()->id_role;

        // Cek apakah role user ada di allowedRoles
        if (!in_array($userRole, $allowedRoles, true)) {
            return redirect()->route('unauthorized');
        }

        return $next($request);
    }
}
