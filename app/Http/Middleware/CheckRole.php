<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user;
        $roles = Role::get()->pluck('id')->toArray();
        $userRole = RoleUser::whereUserId($user->id)->first();
        if (!$user || !$userRole || in_array($userRole->role_id, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
