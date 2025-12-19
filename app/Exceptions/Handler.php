<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Throwable;

use function response;
use function view;
use function config;
use function storage_path;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            if (config('app.debug')) {
                $this->safeLog($e, 'Unhandled exception (reportable)');
            }
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // Handle HttpExceptions first (403, 500, ...)
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
            $statusCode = $exception->getStatusCode();

            if ($statusCode == 403) {
                $message = $exception->getMessage() ?: 'You do not have permission to access this resource.';

                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Forbidden',
                        'error' => $message
                    ], 403);
                }

                if (view()->exists('errors.403')) {
                    return response()->view('errors.403', [
                        'message' => $message
                    ], 403);
                }

                return response($message, 403);
            }

            if ($statusCode == 500) {
                $message = config('app.debug') ? $exception->getMessage() : 'An internal server error occurred. Please try again later.';

                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Internal Server Error',
                        'error' => $message
                    ], 500);
                }

                if (view()->exists('errors.500')) {
                    return response()->view('errors.500', [
                        'message' => $message,
                        'exception' => config('app.debug') ? $exception : null
                    ], 500);
                }

                // fallback textual response
                return response($message, 500);
            }
        }

        // For other exceptions: do minimal, safe logging (so logging failure won't throw)
        if ($exception instanceof \Exception || $exception instanceof \Error) {
            if (config('app.debug')) {
                $this->safeLog($exception, 'Unhandled exception (render)');
            }

            // For production, show friendly error page (without including exception details)
            if (!$request->expectsJson() && !config('app.debug')) {
                if (view()->exists('errors.500')) {
                    return response()->view('errors.500', [
                        'message' => 'An unexpected error occurred. Please try again later.',
                        'exception' => null
                    ], 500);
                }
            }
        }

        return parent::render($request, $exception);
    }

    /**
     * Safely attempt to log an exception. If Log facade fails (e.g. no filesystem access),
     * fallback to a simple file write to storage/logs/fallback_log.txt — and swallow any errors.
     *
     * @param \Throwable $exception
     * @param string|null $contextMessage
     * @return void
     */
    protected function safeLog(Throwable $exception, string $contextMessage = null): void
    {
        try {
            Log::error($contextMessage ?: 'Exception', [
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTraceAsString(),
            ]);
        } catch (Throwable $logException) {
            try {
                $fallbackPath = storage_path('logs/fallback_log.txt');
                $time = date('Y-m-d H:i:s');
                $content = "[$time] Fallback log: " . ($contextMessage ?: '') . PHP_EOL;
                $content .= "Exception: " . $exception->getMessage() . PHP_EOL;
                $content .= "File: " . $exception->getFile() . ' @ line ' . $exception->getLine() . PHP_EOL;
                $content .= "Trace: " . PHP_EOL . $exception->getTraceAsString() . PHP_EOL;
                $content .= "---- Log write error: " . $logException->getMessage() . " ----" . PHP_EOL . PHP_EOL;

                @file_put_contents($fallbackPath, $content, FILE_APPEND | LOCK_EX);
            } catch (Throwable $ignore) {
            }
        }
    }
}
