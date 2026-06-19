<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $cookieRole = $request->cookie('sage_role');
        
        if (!$cookieRole) {
            return redirect('/');
        }

        if ($role === 'admin' && $cookieRole !== 'admin') {
            return redirect('/');
        }

        // Se for rota de user, idealmente só user ou admin podem ver.
        if ($role === 'user' && !in_array($cookieRole, ['admin', 'user'])) {
            return redirect('/');
        }

        return $next($request);
    }
}
