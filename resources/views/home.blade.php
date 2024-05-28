@extends('master')

@section('ogmeta')
<meta property="og:title" content="ProtechEth HOME"/>
<meta property="og:description" content="protechEth makes you coloser to technology and expert on every subject"/>
<meta property="og:image" content=""/>
@endsection
@if(isset($user))
    @section('title')
    {{ $user[0]->name}}
    @endsection
@endif

@section('stylesheets')
@parent
<link href="{{asset('css/home.css')}}" rel="stylesheet">
<link href="{{asset('css/paginate.css')}}" rel="stylesheet">
<link href="{{asset('js/flickity-master/dist/flickity.css')}}" rel="stylesheet">
@if(isset($user))
<style>
    .blog_posts {
        margin-top: 0; 
    }
</style>
@endif
@endsection

@section('navigation')
@include('partials.navigation')
@endsection

@section('content')
@php
    if(isset($user))
    $show_int = showIntro(true);
    else
    $show_int = showIntro(false);
    function showIntro($show)
    {
        if((Request::has('search') && Request::input('search')!='') || Request::has('id') || $show)
            return false;
        return true;
    }
@endphp
@if($show_int)
    <div class="welcome-wrapper">
        <div class="message i1">
            <div>
                <h3><span class="blend">ProtechEth. we will make you skilled on every subject</span></h3>
            </div>
        </div>
        <div class="message i2">
            <div>
                <h3>Did you want to share your skills join us.<br/>Easy to use, Easy to write and easy to share Start now.</h3>
            </div>
        </div>
        <div class="message i3">
                <div>
                    <h3>Did you know that you can have your own page when you start writing your post?</h3>
                </div>
        </div>
        <div class="message i4">
                <div>
                    <h3>Write tutorials,blogs with images,code samples and many more features.</h3>
                </div>
        </div>
    </div>
@endif
@if(isset($user))
<div class="user" id="user">
    <img src="{{ $user[0]->profile_picture}}" class="user-img"/>
    <h3>{{$user[0]->name}}</h3>
    @php
    $user_name = $user[0]->name;
    @endphp
    <user-subscriber :user='@json($user_name)'></user-subscriber>
</div>
@endif
<div class="blog_posts">
    <div class="catagory">
        @if(Request::has('id'))
        <p>Category</p><p>{{$current_catagory}}</p>
        @elseif(Request::input('search')!='')
        <p>search</p><p>{{Request::input('search')}}</p><p>{{count($blogs)}} {{'Result'}}@if(count($blogs)>1){{'s'}} @endif found</p>
        @else
        <p>All</p>
        @endif
    </div>
    @foreach($blogs as $blog)
    <a href="/blog/{{ $blog->id }}">
    <img  class="blog-poster" src="{{ $blog->image }}"  class="intro-img"/>
        <div id="about-blog">
        <p class="blog-title"><i class="fa fa-pen-fancy fa-sm"></i> {{$blog->title}}<br>

        <i class="fa fa-user fa-sm"> </i> By {{ $blog->user->name }}<br>
        <i class="fa fa-calendar-day fa-sm"> </i> {{ $blog -> created_at }}<br>
        <i class="fa fa-comment"></i><i class="fa fa-eye"></i><i class="fa fa-thumb"></i>
        </p>
            <div class="reactions">
                <span><i class="fa fa-comment"></i> {{ $blog -> total_sum_comments }} </span>
                <span><i class="fa fa-eye"></i> {{ $blog->views }} </span>
                <span><i class="fa fa-thumbs-up"></i> {{ $blog->likes }} </span>
            </div>
        </div>
    </a>
    @endforeach
    {{$blogs->links('pagination.paginate')}}
</div>
    <div id="share-catagory">
  <div id="catagory">
    <ul>
        <li class="title">Catagories</li>
        <li><a href="/@if(isset($user)){{'page/'.$user[0]->name}}@endif">All</a></li>
        @php
        $current_url = Request::url();
        $url = substr($current_url,0,strpos($current_url,'/catagory'));
        if($url == "")
        $url = $current_url;
        @endphp
        @foreach($catagories as $catagory)
        <li><a href="@if(Request::is('page/*')){{$url.'/catagory?id='}}@else{{'/catagory?id='}}@endif{{$catagory->id}}"
                     @if(Request::input('id') == $catagory->id)class={{"active-catagory"}}@endif>{{$catagory->catagory}}</a></li>
        @endforeach
    </ul>
 </div>
@if($social_links)
 <div id="share">
    <span class="share-msg"><i class="fa fa-link"></i> Stay connected @if(isset($user)) With <strong>{{$user[0]->name}}</strong>@endif</span>
    @if($social_links[0]->fb != null)<span class="fb"><a href="{{$social_links[0]->fb}}"><i class="fab fa-facebook"></i> facebook</a></span>@endif
    @if($social_links[0]->yb != null)<span class="yb"><a href="{{$social_links[0]->yb}}"><i class="fab fa-youtube"></i> Youtube</a></span>@endif
    @if($social_links[0]->twt != null)<span class="twt"><a href="{{$social_links[0]->twt}}"><i class="fab fa-twitter"></i> Twiter</a></span>@endif
    @if($social_links[0]->tg != null)<span class="tg"><a href="{{$social_links[0]->tg}}"><i class="fab fa-telegram"></i> Telegram</a></span>@endif
 </div>
@endif
</div>
@endsection

@section('scripts')
@php
$cover_img = (isset($user) && $user[0]->userInfo) ? $user[0]->userInfo->cover_image : '';
@endphp
<script>
    let img = "/{{$cover_img}}";
    let imgElement = document.getElementById('user');
    if(img != '/')
        imgElement.style.backgroundImage ="url("+img+")";
</script>
<script src="{{asset('js/flickity-master/dist/flickity.pkgd.js')}}" defer></script>
<script src="{{asset('js/flickity.js')}}" defer></script>
@endsection
@section('footer')
@include('partials.footer')
@endsection