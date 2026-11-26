<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminAccess
{
    public function handle(Request $request, Closure $next, ?string $role = null): Response
    {
        $user = $request->user();
        if (!$user || !$user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->withErrors(['email' => 'La sesión ya no está autorizada.']);
        }
        abort_unless(in_array($user->role, ['admin', 'superadmin'], true), 403);
        abort_if($role !== null && $user->role !== $role, 403);
        return $next($request);
    }
}
