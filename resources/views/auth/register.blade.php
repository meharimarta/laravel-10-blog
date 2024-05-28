@extends('master')

@section('title')
Register
@endsection

@section('content')
@php
    $csrf_token['token']=csrf_token();
    $state = "register";
    $link = route('register');
@endphp
<register :csrf='@json($csrf_token)' 
          :state='@json($state)'
          :link = '@json($link)'></register>
@endsection