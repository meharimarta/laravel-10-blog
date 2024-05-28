@extends('master')

@section('title')
Reset password
@endsection

@section('content')
@php
    //reset password token
    $csrf_token['token'] = $token;
    $state = "reset";
    $link =  route('password.update');
@endphp
<register :csrf='@json($csrf_token)' 
          :state='@json($state)'
          :link = '@json($link)'></register>
@endsection
