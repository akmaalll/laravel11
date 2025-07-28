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

        // Parse multiple roles (e.g., "1,2,4" becomes [1,2,4])
        $allowedRoles = array_map('intval', explode(',', $role));
        $userRole = auth()->user()->id_role;
        
        // Check if user has any of the allowed roles
        if (!in_array($userRole, $allowedRoles)) {
            // Instead of redirecting, show unauthorized page
            abort(403, 'Unauthorized action. User role: ' . $userRole . ', Required roles: ' . implode(',', $allowedRoles));
        }

        return $next($request);
    }
}
