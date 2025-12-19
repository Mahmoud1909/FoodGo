<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            try {
                if (Auth::guard($guard)->check()) {
                    // استخدام HOME constant من RouteServiceProvider
                    // مع fallback إلى '/dashboard' في حالة عدم وجوده
                    $homePath = RouteServiceProvider::HOME ?? '/dashboard';
                    
                    // محاولة استخدام route name أولاً (أكثر أماناً)
                    try {
                        return redirect()->route('dashboard');
                    } catch (\Exception $e) {
                        // في حالة فشل route، استخدم path مباشرة
                        return redirect($homePath);
                    }
                }
            } catch (\Illuminate\Database\QueryException $e) {
                // في حالة خطأ في قاعدة البيانات، سجّل الخطأ واترك الطلب يمر
                \Log::error('Database error in RedirectIfAuthenticated middleware', [
                    'error' => $e->getMessage(),
                    'guard' => $guard
                ]);
                // لا نوقف الطلب، فقط نتجاهل التحقق من المصادقة
                continue;
            } catch (\Exception $e) {
                // لأي أخطاء أخرى، سجّل واترك الطلب يمر
                \Log::warning('Error in RedirectIfAuthenticated middleware', [
                    'error' => $e->getMessage(),
                    'guard' => $guard
                ]);
                continue;
            }
        }

        return $next($request);
    }
}
