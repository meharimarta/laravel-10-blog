@extends('master')

@section('title')
@if(Auth::user()->id == 1) {{"Admin Dashboard"}} @else {{'Member'}} @endif 
@endsection

@section('stylesheets')
@parent
<link rel="stylesheet" href="{{ asset('css/dashboard.css')}}">
<link rel="stylesheet" href="{{ asset('css/sidemenu.css')}}">
@endsection

@section('navigation')
@include('partials.navigation')
@endsection

@section('content')
@include('partials.sidemenu')
<div class="posts" style="color: #fff">
        <a href="{{ url('/dashboard/allblog') }}" title="List all blogs">
		  <div class="post posted" >
            <div class="icon"><i class="fa fa-blog"></i>  </div> 
            <h3>Posts {{ $data['published']}} </h3>
		  </div>
        </a>
        <a href="{{ url('/dashboard/catagories') }}">
		  <div class="post catagory">
            <div class="icon"><i class="fa fa-tag"></i></div>
            <h3>  Catagories {{ $data['catagories']}} </h3>
		  </div>
        </a>
	    <!-- draft blogs -->
	    <a href="@if($data['drafts'] > 0){{url('/dashboard/allblog')}}?get=draft @else {{'#'}} @endif">
		  <div class="post draft">
            <div class="icon"><i class="fa fa-drafting-compass"></i></div>
			<h3>  Drafts {{ $data['drafts']}}</h3>
		  </div>
		</a>
    @can('member-approve')
        <div class="member-wrapper">
            <p><i class="fa fa-user-circle"></i> Members</p>
            <div>
<!--                new members component-->
                <new-members></new-members>
<!--                message component-->
                <member-message></member-message>
            </div>
        </div>
    @endcan
<!--
    <div class="chart-wrapper">
        <p><i class="fa fa-cog"></i> Trfic</p>
        <div class="chart">
            <div class="chartjs">
                <canvas id="trafic-chart" height="200" width="700"></canvas>
            </div>
        </div> 
    </div>
-->
</div>
@endsection

@section('footer')
<div style="text-align: center">
    protech 2020 &copy;
</div>
@endsection

@section('scripts')
    <script src="{{asset('js/chart.js/Chart.js')}}"></script>
    <script src="{{asset('js/view-chart.js')}}" defer></script>
@endsection