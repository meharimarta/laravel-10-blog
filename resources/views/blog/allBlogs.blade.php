@extends('master')
@section('title')
@if(Request::is('dashboard/trashes'))
Trashed posts
    @php
        $istrash = array('istrash'=>true);
        $status = 'Trashed';
    @endphp
@elseif(Request::has('get'))
    Drafts
    @php
        $status = 'Drafts';
        $istrash = array('istrash'=>false);
    @endphp
@else
All blogs
    @php
        $istrash = array('istrash'=>false);
        $status = 'All';
    @endphp
@endif

@endsection

@section('stylesheets')
@parent
<link rel="stylesheet" href="{{asset('css/sidemenu.css')}}">
<style>

</style>
@endsection

@section('navigation')
@include('partials.navigation')
@endsection

@section('content')
@include('partials.sidemenu')
<blogs-component :blogs='@json($allBlogs)' :trash='@json($istrash)' :status='@json($status)'></blogs-component >
<div id="deleting" v-if="deleting">
        @{{deletingMsg}}<br>
    <i style="color:red" class= "fa fa-spinner fa-spin fa-2x fa-fw" ></i>
</div>
<div id="done" v-if="done">
        Deleted Succesfuly<br>
    <i style="color:#003116" class= "fa fa-check"></i>
</div>
@endsection

@section('footer')
@include('partials.simpleFooter')
@endsection
