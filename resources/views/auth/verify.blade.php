@extends('layouts.master')

@section('content')
<div id="main-content" style="margin-right: 300px;">
  <div class="wrapper">
    <h3><i class="fa fa-angle-left"></i>حساب جديد</h3>
    <div class=" row  mt" dir="rtl">
        <div class="col-md-9">
            <div class="content-panel">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
