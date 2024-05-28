@extends('master')

@section('title')
@if(isset($blog))
Edit 
@else
Create new blog
@endif
@endsection

@section('stylesheets')
@parent
<link rel="stylesheet" href="{{asset('prism/css/prism2.css')}}"/>
<link rel="stylesheet" href="{{asset('css/sidemenu.css')}}">
@endsection

@section('navigation')
@include('partials.navigation')
@endsection

@section('content')
@include('partials.sidemenu')
@if(isset($blog))
<new-blog :editblog='@json($blog)' :catagorys='@json($catagorys)' :post_images='@json($post_images)'></new-blog>
@else
<new-blog :catagorys='@json($catagorys)'></new-blog>
@endif
@endsection
@section('footer')
@include('partials.simpleFooter')
@endsection

@section('scripts')
@parent
<script src="{{asset('prism/js/prism.js')}}"></script>
@endsection