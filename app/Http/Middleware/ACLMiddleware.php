<?php

namespace App\Http\Middleware;

use App\Repositories\UserRepository;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class ACLMiddleware
{
    public function __construct(private UserRepository $userRepository)
    {

    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeName = Route::currentRouteName();
        if (! $this->userRepository->hasPermissions($request->user(), $routeName)) {
            return response()->noContent(HttpResponse::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
