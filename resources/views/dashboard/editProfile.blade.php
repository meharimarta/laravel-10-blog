@extends('master')

@section('title')
| profile
@endsection

@section('stylesheets')
@parent
<link rel="stylesheet" href="{{ asset('css/sidemenu.css')}}">
<!--<link rel="stylesheet" href="{{ asset('css/profile.css')}}">-->
@endsection

@section('navigation')
@include('partials.navigation')
@endsection

@section('content')
@include('partials.sidemenu')
@php
    $default_img = asset("assets/user.png");
@endphp
<profile-component :user='@json($user[0])' :defaultimg='@json($default_img)'></profile-component>
@endsection

@section('footer')
@include('partials.simpleFooter')
@endsection

@section('scripts')
<!--<script src="{{ asset('js/profile.js') }}"></script>-->
@parent
@endsection
