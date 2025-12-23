<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Debug pour voir si le middleware est appelé
        \Log::info('AdminMiddleware: Vérification accès admin', [
            'path' => $request->path(),
            'session_data' => session()->all(),
            'is_admin' => session()->get('is_admin'),
            'admin_id' => session()->get('admin_id')
        ]);

        if (!session()->get('is_admin') || !session()->get('admin_id')) {
            \Log::warning('AdminMiddleware: Accès refusé - session admin manquante');
            return redirect('/connexion')->with('error', 'Accès non autorisé. Veuillez vous connecter en tant qu\'administrateur.');
        }

        \Log::info('AdminMiddleware: Accès autorisé');
        return $next($request);
    }
}
