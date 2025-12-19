@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
            <div class="col-md-8 text-center">
                <div class="error-box">
                    <h1 class="error-code" style="font-size: 120px; font-weight: bold; color: #e74c3c; margin-bottom: 20px;">500</h1>
                    <h2 class="error-title" style="font-size: 32px; margin-bottom: 15px; color: #2c3e50;">
                        {{ trans('lang.server_error') ?? 'Server Error' }}
                    </h2>
                    <p class="error-message" style="font-size: 18px; color: #7f8c8d; margin-bottom: 30px;">
                        @if(isset($message))
                            {{ $message }}
                        @else
                            {{ trans('lang.server_error_message') ?? 'We\'re sorry, but something went wrong on our end. Our team has been notified and is working to fix the issue.' }}
                        @endif
                    </p>
                    <div class="error-actions">
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary" style="margin-right: 10px;">
                            <i class="fa fa-home"></i> {{ trans('lang.go_to_dashboard') ?? 'Go to Dashboard' }}
                        </a>
                        <a href="javascript:history.back()" class="btn btn-default" style="margin-right: 10px;">
                            <i class="fa fa-arrow-left"></i> {{ trans('lang.go_back') ?? 'Go Back' }}
                        </a>
                        <button onclick="location.reload()" class="btn btn-info">
                            <i class="fa fa-refresh"></i> {{ trans('lang.refresh') ?? 'Refresh Page' }}
                        </button>
                    </div>
                    
                    @if(config('app.debug') && isset($exception))
                        <div class="error-debug mt-4" style="padding: 20px; background: #f8f9fa; border-radius: 5px; margin-top: 30px; text-align: left;">
                            <h4 style="color: #dc3545; margin-bottom: 15px;">
                                <i class="fa fa-bug"></i> Debug Information
                            </h4>
                            <div style="font-family: monospace; font-size: 12px; color: #495057;">
                                <p><strong>Error:</strong> {{ $exception->getMessage() }}</p>
                                <p><strong>File:</strong> {{ $exception->getFile() }}</p>
                                <p><strong>Line:</strong> {{ $exception->getLine() }}</p>
                                @if(method_exists($exception, 'getTraceAsString'))
                                    <details style="margin-top: 10px;">
                                        <summary style="cursor: pointer; color: #007bff;">Stack Trace</summary>
                                        <pre style="margin-top: 10px; padding: 10px; background: #fff; border: 1px solid #dee2e6; border-radius: 3px; overflow-x: auto; max-height: 300px; overflow-y: auto;">{{ $exception->getTraceAsString() }}</pre>
                                    </details>
                                @endif
                            </div>
                        </div>
                    @endif
                    
                    <div class="error-info mt-4" style="padding: 15px; background: #e7f3ff; border-radius: 5px; margin-top: 30px;">
                        <p style="margin: 0; color: #0066cc; font-size: 14px;">
                            <i class="fa fa-info-circle"></i> 
                            {{ trans('lang.error_help_message') ?? 'If this problem persists, please contact support with the error code above.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .error-box {
        padding: 40px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .error-code {
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }
    
    @media (max-width: 768px) {
        .error-code {
            font-size: 80px !important;
        }
        .error-title {
            font-size: 24px !important;
        }
        .error-message {
            font-size: 16px !important;
        }
        .error-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .error-actions .btn {
            width: 100%;
            margin-right: 0 !important;
        }
    }
</style>
@endsection

