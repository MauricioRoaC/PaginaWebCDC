<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\IpUtils;
use Symfony\Component\HttpFoundation\Response;

class EnsurePrivateNetwork
{
    public function handle(Request $request, Closure $next): Response
    {
        if (app()->environment('local', 'testing') && !config('admin.restrict_network')) {
            return $next($request);
        }

        // Explicit temporary demonstration mode; authentication remains mandatory.
        if (config('admin.access_mode') === 'demo' && !config('admin.restrict_network')) {
            return $next($request);
        }

        $ranges = config('admin.allowed_networks', []);
        abort_unless($ranges && IpUtils::checkIp($request->ip(), $ranges), 403);
        return $next($request);
    }
}
