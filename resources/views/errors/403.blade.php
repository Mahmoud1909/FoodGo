@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
            <div class="col-md-6 text-center">
                <div class="error-box">
                    <h1 class="error-code" style="font-size: 120px; font-weight: bold; color: #e74c3c; margin-bottom: 20px;">403</h1>
                    <h2 class="error-title" style="font-size: 32px; margin-bottom: 15px; color: #2c3e50;">
                        {{ trans('lang.access_denied') ?? 'Access Denied' }}
                    </h2>
                    <p class="error-message" style="font-size: 18px; color: #7f8c8d; margin-bottom: 30px;">
                        @if(isset($message))
                            {{ $message }}
                        @else
                            {{ trans('lang.unauthorized_access_message') ?? 'You do not have permission to access this resource.' }}
                        @endif
                    </p>
                    <div class="error-actions">
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary" style="margin-right: 10px;">
                            <i class="fa fa-home"></i> {{ trans('lang.go_to_dashboard') ?? 'Go to Dashboard' }}
                        </a>
                        <a href="javascript:history.back()" class="btn btn-default">
                            <i class="fa fa-arrow-left"></i> {{ trans('lang.go_back') ?? 'Go Back' }}
                        </a>
                    </div>
                    @if(auth()->check())
                        <div class="error-info mt-4" style="padding: 15px; background: #f8f9fa; border-radius: 5px; margin-top: 30px;">
                            <p style="margin: 0; color: #6c757d; font-size: 14px;">
                                <strong>{{ trans('lang.logged_in_as') ?? 'Logged in as' }}:</strong> {{ auth()->user()->name ?? auth()->user()->email }}
                            </p>
                            <p style="margin: 5px 0 0 0; color: #6c757d; font-size: 14px;">
                                <strong>{{ trans('lang.role') ?? 'Role' }}:</strong> {{ session('user_role') ?? 'N/A' }}
                            </p>
                            <p style="margin: 10px 0 0 0; color: #dc3545; font-size: 13px;">
                                <i class="fa fa-info-circle"></i> {{ trans('lang.contact_admin_for_permissions') ?? 'If you believe this is an error, please contact your administrator.' }}
                            </p>
                        </div>
                    @endif
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
    }
</style>
@endsection

