@extends('master')

@section('title')
verify email
@endsection

@section('stylesheets')
@parent
<link href="{{asset('css/verify.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="verify-body">
<div class="verify-wrapper">
    <div class="header">{{ __('Verify Your Email Address') }}</div>

    <div class="body">
        @if (session('resent'))
            <div class="alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif

        {{ __('Before proceeding, please check your email for a verification link.') }}
        {{ __('If you did not receive the email') }},

    </div>
        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
        </form>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
    </form>
        <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }} <i class="fa fa-sign-out-alt"></i>
        </a>
</div>
</div>
@endsection
