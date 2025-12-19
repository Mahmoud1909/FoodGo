<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\Permission;
use Auth;
use Closure;

class CheckUserRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            try {
                $user = auth()->user();
                
                // Check if user has role_id
                if (empty($user->role_id)) {
                    \Log::warning('User ' . $user->id . ' has no role_id assigned');
                    session(['user_role' => 'No Role', 'user_permissions' => json_encode([])]);
                    return $next($request);
                }

                try {
                    $role_has_permissions = Permission::where('role_id', $user->role_id)->pluck('routes')->toArray();
                    $role_has_permissions = array_unique($role_has_permissions);
                } catch (\Exception $e) {
                    \Log::error('Error loading permissions: ' . $e->getMessage());
                    $role_has_permissions = [];
                }

                try {
                    $users = User::join('role', 'role.id', '=', 'users.role_id')
                        ->where('users.id', '=', $user->id)
                        ->select('role.role_name as roleName')
                        ->first();
                    
                    if ($users && $users->roleName) {
                        session(['user_role' => $users->roleName, 'user_permissions' => json_encode($role_has_permissions)]);
                    } else {
                        \Log::warning('User ' . $user->id . ' role not found in role table');
                        session(['user_role' => 'Unknown', 'user_permissions' => json_encode($role_has_permissions)]);
                    }
                } catch (\Exception $e) {
                    \Log::error('Error loading user role: ' . $e->getMessage());
                    session(['user_role' => 'Unknown', 'user_permissions' => json_encode($role_has_permissions)]);
                }
            } catch (\Exception $e) {
                \Log::error('CheckUserRoleMiddleware error: ' . $e->getMessage());
                // Don't block request, just log error
                session(['user_role' => 'Unknown', 'user_permissions' => json_encode([])]);
            }
        }
        return $next($request);
    }
}