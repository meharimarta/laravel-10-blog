@extends('master')

@section('ogmeta')
<meta property="og:title" content="protecheth digital library"/>
<meta property="og:description" content="Digital library for every one for free in amharic,English ..."/>
<meta property="og:image" content=""/>
@endsection

@section('title')
{{ 'Library' }}
@endsection

@section('stylesheets')
@parent


<link href="{{asset('css/bootstrap/css/bootstrap-grid.css')}}" rel="stylesheet">
<link href="{{asset('css/library.css')}}" rel="stylesheet">
<link href="{{asset('css/paginate.css')}}" rel="stylesheet">
<link href="{{asset('js/flickity-master/dist/flickity.css')}}" rel="stylesheet">
@endsection

@section('navigation')
@include('partials.navigation')
@endsection

@section('content')
           <div class="row">
               
               <div class="link-wrapper col-lg-2 col-md-3 col-sm-12">
                   <a href="#" class="link">
                    <div class="book">
                        <img src="{{asset('assets/im.jpeg')}}"/>
                        <div class="btn">
                            <button>Download</button>
                            <button>View</button>
                        </div>
                        <strong>Writer:</strong> mehari<br>
                        <strong>Title:</strong> the art of enginnering<br>
                        <strong>published date:</strong> 2020/12/11<br>
                    </div>
                   </a>
               </div>
               
               <div class="link-wrapper col-lg-2 col-md-3 col-sm-12">
                   <a href="#" class="link">
                    <div class="book">
                        <img src="{{asset('assets/im.jpeg')}}"/>
                        <div class="btn">
                            <button>Download</button>
                            <button>View</button>
                        </div>
                        <strong>Writer:</strong> mehari<br>
                        <strong>Title:</strong> the art of enginnering<br>
                        <strong>published date:</strong> 2020/12/11<br>
                    </div>
                   </a>
               </div>
               
               <div class="link-wrapper col-lg-2 col-md-3 col-sm-12">
                   <a href="#" class="link">
                    <div class="book">
                        <img src="{{asset('assets/im.jpeg')}}"/>
                        <div class="btn">
                            <button>Download</button>
                            <button>View</button>
                        </div>
                        <strong>Writer:</strong> mehari<br>
                        <strong>Title:</strong> the art of enginnering<br>
                        <strong>published date:</strong> 2020/12/11<br>
                    </div>
                   </a>
               </div>
               
               <div class="link-wrapper col-lg-2 col-md-3 col-sm-12">
                   <a href="#" class="link">
                    <div class="book">
                        <img src="{{asset('assets/im.jpeg')}}"/>
                        <div class="btn">
                            <button>Download</button>
                            <button>View</button>
                        </div>
                        <strong>Writer:</strong> mehari<br>
                        <strong>Title:</strong> the art of enginnering<br>
                        <strong>published date:</strong> 2020/12/11<br>
                    </div>
                   </a>
               </div>
               
               <div class="link-wrapper col-lg-2 col-md-3 col-sm-12">
                   <a href="#" class="link">
                    <div class="book">
                        <img src="{{asset('assets/im.jpeg')}}"/>
                        <div class="btn">
                            <button>Download</button>
                            <button>View</button>
                        </div>
                        <strong>Writer:</strong> mehari<br>
                        <strong>Title:</strong> the art of enginnering<br>
                        <strong>published date:</strong> 2020/12/11<br>
                    </div>
                   </a>
               </div>
               
               <div class="link-wrapper col-lg-2 col-md-3 col-sm-12">
                   <a href="#" class="link">
                    <div class="book">
                        <img src="{{asset('assets/im.jpeg')}}"/>
                        <div class="btn">
                            <button>Download</button>
                            <button>View</button>
                        </div>
                        <strong>Writer:</strong> mehari<br>
                        <strong>Title:</strong> the art of enginnering<br>
                        <strong>published date:</strong> 2020/12/11<br>
                    </div>
                   </a>
               </div>
               
               <div class="link-wrapper col-lg-2 col-md-3 col-sm-12">
                   <a href="#" class="link">
                    <div class="book">
                        <img src="{{asset('assets/im.jpeg')}}"/>
                        <div class="btn">
                            <button>Download</button>
                            <button>View</button>
                        </div>
                        <strong>Writer:</strong> mehari<br>
                        <strong>Title:</strong> the art of enginnering<br>
                        <strong>published date:</strong> 2020/12/11<br>
                    </div>
                   </a>
               </div>
               
               <div class="link-wrapper col-lg-2 col-md-3 col-sm-12">
                   <a href="#" class="link">
                    <div class="book">
                        <img src="{{asset('assets/im.jpeg')}}"/>
                        <div class="btn">
                            <button>Download</button>
                            <button>View</button>
                        </div>
                        <strong>Writer:</strong> mehari<br>
                        <strong>Title:</strong> the art of enginnering<br>
                        <strong>published date:</strong> 2020/12/11<br>
                    </div>
                   </a>
               </div>
               
               <div class="link-wrapper col-lg-2 col-md-3 col-sm-12">
                   <a href="#" class="link">
                    <div class="book">
                        <img src="{{asset('assets/im.jpeg')}}"/>
                        <div class="btn">
                            <button>Download</button>
                            <button>View</button>
                        </div>
                        <strong>Writer:</strong> mehari<br>
                        <strong>Title:</strong> the art of enginnering<br>
                        <strong>published date:</strong> 2020/12/11<br>
                    </div>
                   </a>
               </div>
               
               <div class="link-wrapper col-lg-2 col-md-3 col-sm-12">
                   <a href="#" class="link">
                    <div class="book">
                        <img src="{{asset('assets/im.jpeg')}}"/>
                        <div class="btn">
                            <button>Download</button>
                            <button>View</button>
                        </div>
                        <strong>Writer:</strong> mehari<br>
                        <strong>Title:</strong> the art of enginnering<br>
                        <strong>published date:</strong> 2020/12/11<br>
                    </div>
                   </a>
               </div>
               
               <div class="link-wrapper col-lg-2 col-md-3 col-sm-12">
                   <a href="#" class="link">
                    <div class="book">
                        <img src="{{asset('assets/im.jpeg')}}"/>
                        <div class="btn">
                            <button>Download</button>
                            <button>View</button>
                        </div>
                        <strong>Writer:</strong> mehari<br>
                        <strong>Title:</strong> the art of enginnering<br>
                        <strong>published date:</strong> 2020/12/11<br>
                    </div>
                   </a>
               </div>
               
               <div class="link-wrapper col-lg-2 col-md-3 col-sm-12">
                   <a href="#" class="link">
                    <div class="book">
                        <img src="{{asset('assets/im.jpeg')}}"/>
                        <div class="btn">
                            <button>Download</button>
                            <button>View</button>
                        </div>
                        <strong>Writer:</strong> mehari<br>
                        <strong>Title:</strong> the art of enginnering<br>
                        <strong>published date:</strong> 2020/12/11<br>
                    </div>
                   </a>
               </div>
               
           </div>
@endsection
@section('footer')
@include('partials.footer')
@endsection