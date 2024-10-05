<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $userRole = RoleUser::whereUserId($user->id)->first();

        if ($userRole->role_id !== 1) {
            // dd('fail');
            abort(403, 'Unauthorized');
        }

        // dd('success', $userRole->role_id);

        return $next($request);
    }
}
