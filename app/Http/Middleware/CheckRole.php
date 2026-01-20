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
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        $userRole = strtolower($user->role->nama_role);

        if ($userRole !== strtolower($role)) {

            $redirectRoute = match ($userRole) {
                'admin_data' => 'admin-data.dashboard',
                'admin_pusat' => 'admin-pusat.dashboard',
                'ketua' => 'ketua.dashboard',
                'warga' => 'warga.dashboard',
                default => 'home',
            };
            
            return redirect()->route($redirectRoute);
        }

        return $next($request);
    }
}