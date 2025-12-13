<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AjaxOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Разрешаем только AJAX/JSON запросы
        if (($request->is('api/*') || $request->is('api/CRUD/*'))
            && !$request->ajax()
            && !$request->wantsJson()) {

            // Для любых методов (GET, POST, PUT, DELETE)
            return redirect()->back()->with('error', 'Доступ только через AJAX запросы');
        }

        return $next($request);
    }
}
