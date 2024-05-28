@extends('master')

@section('title')
Notifications
@endsection

@section('stylesheets')
@parent
<link rel="stylesheet" href="{{ asset('css/sidemenu.css')}}">
@endsection

@section('navigation')
@include('partials.navigation')
@endsection

@section('content')
@include('partials.sidemenu')
@php
$csrf = array('token' => csrf_token());
$admin = array('is_admin' => true,'name'=>Auth::user()->name);
@endphp

<Notification :image='@json(["image" => asset("assets/blogenium-cool-technologies-wallpapers-18.jpg")])'
              :notifications='@json($notifications)'
              :csrf='@json($csrf)'
              :admin='@json($admin)'
              ></Notification>
@endsection

@section('footer')
@include('partials.simpleFooter')
@endsection

@section('scripts')
@parent
@endsection