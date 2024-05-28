@extends('master')

@section('title')
 Become member
@endsection


@section('stylesheets')
@parent
<link href="{{asset('css/member.css')}}" rel="stylesheet">
@endsection

@section('navigation')
@include('partials.navigation')
@endsection

@section('content')
<div class="content-wrapper">
    <div class="member">
        <div class="note">
            <p>Become member on our site and write posts to the world </p>
            <div class="icons">
                <div>
                    <i class="fa fa-pen-fancy"></i>
                    Start writing now
                    <a href="{{url('/login')}}">Start</a>
                </div>
               <div>
                    <i class="fa fa-cogs"></i>
                    show Your skills
                </div> 
               <div>
                    <i class="fa fa-hands-helping"></i>
                    help others
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
@include('partials.footer')
@endsection

