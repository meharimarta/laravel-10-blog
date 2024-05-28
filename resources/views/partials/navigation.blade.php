<div  class="brand">
   <div>@if(!isset($user)) Pr <i class="fa fa-cog fa-xs fa-spin"></i>techEt <i class="fa fa-bolt fa-xs"></i>@else {{$user[0]->name}}@endif </div>
</div>
<div class="bar wbc" @click="flip" id="toogle-btn">
    <span :class="{ bar1: true, bar1_flip: flipc }"></span>
    <span :class="{ bar2: true, bar2_flip: flipc }"></span>
    <span :class="{ bar3: true, bar3_flip: flipc }"></span>
</div>
<div class='nav-links'>
    <a href="{{ Request::url()}}" class="@if(Request::url() == url('/')) {{ 'active'}} @endif">Home <i class="fa fa-home"></i></a>
<!--    <a href="{{url('/contact')}}" class="@if(Request::url() == url('/contact')) {{ 'active' }} @endif">Contact <i class="fa fa-phone"></i></a>-->
    <a href="{ Request::url(). '/lib'}}/" class="@if(Request::url() == url('/lib')) {{ 'active'}} @endif">Library <i class="fa fa-info"></i></a>
    <a href="{{ Request::url(). '/member'}}" class="@if(Request::url() == url('/member')) {{ 'active' }} @endif">Meber <i class="fa fa-user-circle"></i></a>
    <form id="search" action=""><input id="nav-search" name="search" type="text" placeholder="search"/><button type="submit"><i class="fa fa-search"></i></button></form>
</div>