@extends('master')

@section('title')
catagories
@endsection

@section('stylesheets')
@parent
<link rel="stylesheet" href="{{asset('css/sidemenu.css')}}">
@endsection

@section('navigation')
@include('partials.navigation')
@endsection

@section('content')
@include('partials.sidemenu')
<Catagories :catagories='@json($catagories)'></Catagories>
@endsection

@section('footer')
@section('partials.simpleFooter')
@endsection

@section('scripts')
@parent
@endsection
