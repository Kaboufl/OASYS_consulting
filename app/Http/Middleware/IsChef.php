<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsChef
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->user()->chefDe) {
            //return response('Pas chef de projet', 403);
            return redirect()->to('/')->withErrors(['admin' => 'Vous devez être de projet !']);
        }
        return $next($request);
    }
}
