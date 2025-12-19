<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission = null, $routes = null)
    {
        if (!auth()->check()) {
            // User is not authenticated, redirect to login
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthenticated',
                    'error' => 'You must be logged in to access this resource.'
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Please login to continue');
        }

        $user = auth()->user();
        
        // Check if user has a valid role_id
        if (empty($user->role_id)) {
            \Log::warning('User ' . $user->id . ' has no role_id assigned');
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthorized',
                    'error' => 'Your account does not have a role assigned. Please contact administrator.'
                ], 403);
            }
            abort(403, 'Your account does not have a role assigned. Please contact administrator.');
        }

        // If no permission is required, allow access
        if ($permission == null) {
            return $next($request);
        }

        try {
            // Check if permissions table exists and has data
            try {
                $role_has_permissions = Permission::where('role_id', $user->role_id)->pluck('permission')->toArray();
                $role_has_permissions = array_unique($role_has_permissions);
            } catch (\Illuminate\Database\QueryException $e) {
                // Table doesn't exist or database error
                \Log::error('Permission table error: ' . $e->getMessage());
                // For development: allow access if permissions table doesn't exist
                if (config('app.debug')) {
                    \Log::warning('Permissions table not found or empty. Allowing access in debug mode.');
                    return $next($request);
                }
                // For production: deny access
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Internal Server Error',
                        'error' => 'Permissions system not configured. Please contact administrator.'
                    ], 500);
                }
                abort(500, 'Permissions system not configured. Please contact administrator.');
            }
            
            // If no permissions found for this role, check if we should allow access
            if (empty($role_has_permissions)) {
                \Log::warning('User ' . $user->id . ' has role_id ' . $user->role_id . ' but no permissions assigned');
                // For development: allow access if no permissions
                if (config('app.debug')) {
                    \Log::warning('No permissions found for user. Allowing access in debug mode.');
                    return $next($request);
                }
                // For production: deny access
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Forbidden',
                        'error' => 'Your account does not have any permissions assigned. Please contact administrator.'
                    ], 403);
                }
                abort(403, 'Your account does not have any permissions assigned. Please contact administrator.');
            }
            
            if (in_array($permission, $role_has_permissions)) {
                // Permission exists, check route if specified
                if ($routes == null) {
                    return $next($request);
                }
                
                try {
                    $permission_has_routes = Permission::where('role_id', $user->role_id)
                        ->where('permission', $permission)
                        ->pluck('routes')
                        ->toArray();
                    
                    if (in_array($routes, $permission_has_routes)) {
                        return $next($request);
                    } else {
                        // User has permission but not for this specific route
                        \Log::warning('User ' . $user->id . ' attempted to access route ' . $routes . ' without permission');
                        if ($request->expectsJson()) {
                            return response()->json([
                                'message' => 'Forbidden',
                                'error' => 'You do not have permission to access this route.'
                            ], 403);
                        }
                        abort(403, 'You do not have permission to access this route.');
                    }
                } catch (\Exception $e) {
                    \Log::error('Error checking permission routes: ' . $e->getMessage());
                    // For development: allow access on error
                    if (config('app.debug')) {
                        return $next($request);
                    }
                    abort(403, 'You do not have permission to access this route.');
                }
            } else {
                // User doesn't have the required permission
                \Log::warning('User ' . $user->id . ' attempted to access permission ' . $permission . ' without authorization');
                // For development: allow access if permission not found
                if (config('app.debug')) {
                    \Log::warning('Permission ' . $permission . ' not found for user. Allowing access in debug mode.');
                    return $next($request);
                }
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Forbidden',
                        'error' => 'You do not have permission to perform this action.'
                    ], 403);
                }
                abort(403, 'You do not have permission to perform this action.');
            }
        } catch (\Exception $e) {
            \Log::error('Permission check error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // For development: show detailed error
            if (config('app.debug')) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Internal Server Error',
                        'error' => 'An error occurred while checking permissions.',
                        'debug' => [
                            'message' => $e->getMessage(),
                            'file' => $e->getFile(),
                            'line' => $e->getLine()
                        ]
                    ], 500);
                }
                abort(500, 'An error occurred while checking permissions: ' . $e->getMessage());
            }
            
            // For production: generic error
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Internal Server Error',
                    'error' => 'An error occurred while checking permissions.'
                ], 500);
            }
            abort(500, 'An error occurred while checking permissions.');
        }
    }
}