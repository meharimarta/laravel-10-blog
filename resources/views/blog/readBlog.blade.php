@extends('master')
@section('stylesheets')
@parent
<link rel="stylesheet" href="{{asset('prism/css/prism.css')}}"/>
<link rel="stylesheet" href="{{asset('css/readblog.css')}}"/>
<link href="{{asset('js/flickity-master/dist/flickity.css')}}" rel="stylesheet">
@endsection
@section('ogmeta')
<meta property="og:title" content="{{$blog[0]->title}}"/>
<meta property="og:description" content=""/>
<meta property="og:image" content="{{$blog[0]->image}}"/>
@endsection
@section('title')
{{$blog[0]->title}}
@endsection

@section('navigation')
@include('partials.navigation')
@endsection

@section('content')
<div class="blog-post-wrapper">
    <div class="blog-img">
        <img src="{{$blog[0]->image}}" id="poster-img"/>
        <div class="blogger">
            
            <img src="{{$blog[0] -> user -> profile_picture}}" id="user-img"/>
         <h3 id="user-name">{{$blog[0] -> user -> name}}</h3>
        </div>
    </div>
    <div class="blog-title">
        <h2>{{$blog[0]->title}}</h2>
    </div>
    <div class="blog-content">
        {!!$blog[0]->post!!}

        <div class="react" @click="likepost({{$blog[0]->id}})"><i class="fa fa-thumbs-up"></i> @{{ likes }} </div>
        <div class="more-wrapper"><a class="more" href="/page/{{$blog[0]->user->name}}">Need More from<strong>{{$blog[0]->user->name}}</strong> </a></div>
    </div>
@if($blog[0]->deleted_at == null)
    @php
    $data = array('csrf_token'=>csrf_token(),'id'=>$blog[0]->id,'comments'=>$comments);
    $user_commented_before = array('commenter_name' => Request::session()->has('commenter_name') ? session()->get('commenter_name') : false);
    @endphp
<!--    *********************************************************-->
<!--    comments section  comments vue component-->
    <comments :data='@json($data)'
              :usercommented = '@json($user_commented_before)'></comments>
<!--   **************************************************-->
    <p class="recent-title">Recent posts from <strong>{{$blog[0] -> user -> name}}</strong></p>
    <div class="recent-posts">
        @foreach($recent_posts as $post)
              <a href="./{{$post->id}}" class="post-link">
                <img src="{{$post->image}}"/>
                    <div class="about-post">
                        <p>{{$post->title}} </p>
                    </div>
            </a>
        @endforeach
    </div>
    @endif
</div>
@endsection

@section('footer')
@include('partials.footer');
<?php $__env->stopSection(); ?>

 @section('scripts')
<script>
    window.likes = {{$blog[0]->likes}}
</script>
<script src="{{asset('prism/js/prism.js')}}"></script>
<script src="{{asset('js/flickity-master/dist/flickity.pkgd.js')}}" defer></script>
<script src="{{asset('js/flickity.js')}}" defer></script>
@endsection