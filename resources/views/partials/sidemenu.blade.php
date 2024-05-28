<?php 
//require_once('./sideLinks.php') 
$sideLinks = array(
                    [
                    'name' => 'Catagories',
                    'link' => 'dashboard/catagories',
                    'icon' => 'fa-tag'
                    ],
                    [
                    'name' => 'Notifications',
                    'link' => 'dashboard/notifications',
                    'icon' => 'fa-bell'
                    ],
                    [
                    'name' => 'Edit profile',
                    'link' => 'dashboard/profile',
                    'icon' => 'fa-edit'
                    ]
);
?>
<div id="toggle-btn" @click.stop="side()">
  	<i class="fa fa-ellipsis-v" ></i>
</div>
<div class="side" id="side":class="{toggle: toggleSide}">
    <div class="user-name-wrapper"><img src="{{$user_picture[0]->profile_picture}}" id="user-img"/><span  id="user-name">{{ Request::user()->name }}</span></div>
<!--        <button @click.stop="side()" id="close-side">X</button>-->
    <a id="dashboard-link" href="{{ url('/dashboard') }}">
    <p class="catagory-" id="dashboard">Dashboard  <i class="fa fa-tachometer-alt"></i></p>
    </a>
    <ul>
        <li>
            @php
            $sub_links = array('dashboard/newblog','dashboard/allblog','dashboard/trashes');
            $is_sub_link = false;
            for($i = 0; $i < count($sub_links); $i++)
            {
                if(Request::is($sub_links[$i])) 
                {
                    $is_sub_link = true;
                }                                                    
            }
            @endphp
            <a class="@if(!$is_sub_link) toggle @endif" style="cursor: pointer"><i class="fa fa-plus-circle"></i> Post</a> 
            <ul id="in-ul" style="@if(!$is_sub_link) display:none @endif">
                <li><a href="{{url('dashboard/newblog')}}" class="@if(Request::is('dashboard/newblog')) active @endif"><i class="fa fa-plus"></i> New post</a></li>
                <li><a href="{{url('dashboard/allblog')}}" class="@if(Request::is('dashboard/allblog')) active @endif"><i class="fa fa-blog"></i> All posts</a></li>
                <li><a href="{{url('/dashboard/trashes')}}" class="@if(Request::is('dashboard/trashes')) active @endif"><i class="fa fa-trash"> Trashs </i><span class="tag">{{ $trashes }}</span></a></li>
                
            </ul>
        </li>
         @foreach($sideLinks as $link)
            @php
            $url = $link['link'];
            $active_class = 'active';
            @endphp
            <li>
                <a href="{{ url($url) }}" class="@if(Request::url() == url($url)) {{ $active_class }} @endif"><i class="fa {{ $link['icon'] }}"> 
                {{ $link['name']}} 
                </i>
                @if($link['name'] =='Notifications' )
                    <span class="tag">{{$notifications}}</span>
                @endif
                </a>
            </li>
         @endforeach
        <li>
             <form id="form" method="post" action="/logout">
                {{ csrf_field()}}
                 <button type="submit"><i class="fa fa-sign-out-alt"></i> Logout {{ Request::user()->name}} </button>
            </form>    
        </li>
        <li><a disabled></a></li>
        <li><a disabled></a></li>
        <li><a disabled></a></li>
    </ul>
</div>