<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsChef;

class IsCadre
{
    protected $isAdmin;
    protected $isChef;

    public function __construct(IsAdmin $isAdmin, IsChef $isChef)
    {
        $this->isAdmin = $isAdmin;
        $this->isChef = $isChef;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            return $this->isChef->handle($request, $next);
        } catch (\Throwable $th) {
            // Ce n'est pas non plus un chef de projet, on le redirige...
            return response('Unauthorized.', 401);
        }

        try {
            return $this->isAdmin->handle($request, $next);
        } catch (\Throwable $th) {
            // Ce n'est pas un admin
        }
    }
}
