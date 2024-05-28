@extends('master')

@section('title')
Reset password
@endsection

@section('content')
@php
    $csrf_token = csrf_token();
    $link = route('password.email');
    $default_img = asset("assets/user.png");
    $state = 'reset';
@endphp
    <login :csrf = '@json($csrf_token)'
           :defaultimg = '@json($default_img)' 
           :state = '@json($state)'
            :link = '@json($link)'></login>
@endsection
