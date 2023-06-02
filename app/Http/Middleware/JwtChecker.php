<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Errors\Http\JwtException;

class JwtChecker
{
    public function handle(Request $request, Closure $next): Response
    {
        $authorization = $request->header(key: 'Authorization', default: '');

        if (empty($authorization)) {
            throw new JwtException;
        }

        return $next($request);
    }
}
