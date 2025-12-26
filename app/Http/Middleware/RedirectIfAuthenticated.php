<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Role to route mapping
     */
    protected $roleRoutes = [
        'admin' => 'admin.dashboard',
        'ustadz' => 'ustadz.dashboard',
        'ustadzah' => 'ustadz.dashboard',
        'santri_putra' => 'santri.dashboard',
        'santri_putri' => 'santri.dashboard',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return $this->redirectAuthenticatedUser(Auth::guard($guard)->user());
            }
        }

        return $next($request);
    }

    /**
     * Redirect authenticated user based on role
     */
    protected function redirectAuthenticatedUser($user): Response
    {
        $route = $this->roleRoutes[$user->role] ?? 'dashboard';
        return redirect()->route($route);
    }
}