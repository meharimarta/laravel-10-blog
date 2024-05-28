@extends('master')

@section('title')
Login
@endsection

@section('content')
@php
    $csrf_token['token']=csrf_token();
    $link = '/login';
    $reset_link = '/password/reset';
    $default_img = asset("assets/user.png");
    $state = 'login';
@endphp
    <login :csrf = '@json($csrf_token)' 
           :defaultimg = '@json($default_img)' 
           :state='@json($state)'
           :link = '@json($link)'
           :reset = '@json($reset_link)'></login>
@endsection
