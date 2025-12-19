<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Add Content Security Policy header with unsafe-eval for JavaScript libraries
        // This is needed for libraries like DataTables, jQuery, etc. that use eval()
        // Also allows WebSocket connections for Firebase Realtime Database
        $csp = "default-src 'self'; " .
               "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.datatables.net https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://code.jquery.com https://unpkg.com https://*.googleapis.com https://*.gstatic.com https://*.firebase.com https://*.firebaseio.com https://*.google.com https://www.gstatic.com; " .
               "style-src 'self' 'unsafe-inline' https://cdn.datatables.net https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://fonts.googleapis.com https://unpkg.com https://code.jquery.com https://*.gstatic.com; " .
               "font-src 'self' https://fonts.gstatic.com https://fonts.googleapis.com data:; " .
               "img-src 'self' data: https: http: blob:; " .
               "connect-src 'self' https://*.googleapis.com https://*.firebase.com https://*.firebaseio.com https://*.google.com https://www.googleapis.com https://firestore.googleapis.com https://firebaselogging.googleapis.com https://unpkg.com wss://*.firebaseio.com ws://*.firebaseio.com https://*.firebaseio.com; " .
               "frame-src 'self' https://*.google.com https://*.googleapis.com https://*.gstatic.com; " .
               "object-src 'none'; " .
               "base-uri 'self'; " .
               "form-action 'self'; " .
               "frame-ancestors 'none';";

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}

