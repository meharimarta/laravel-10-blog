
<div class="footer-content">
    @if(!isset($user))
    <div class="form">
        <i class="fa fa-envelope fa-3x"></i><br>
        <div class="long-bar"></div>
        <em style="font-size: 1.3em; margin-bottom: 10px;">Subscribe to our newsletter</em><br>
        <p>Get the letest news and updates deliverd directly in to your inbox.</p>
<!--        Subscribe on <strong>protechrth</strong> to get notified for new events and posts-->
        <div>
        <input type="email" name="email" v-model="email" placeholder="Email Adress"/>
        <button @click="subscribe">Subscribe<i class="fa fa-spinner fa-spin" v-if="subscribing"></i></button>
        <br><span class="info" style="color: #fbc86a">@{{ subscriptionInfo }}</span>
        </div>
    </div>
    <div class="about">
        <i class="fa fa-handshake fa-3x"></i><br>
        <p>Just share what u have and what you know there is noting hidden in this world.</p>
    </div>
    <div  class="notice">
        <i class="fa fa-cogs fa-3x"></i><br>
<!--        <p>Just share what u have and what you know there is noting hidden in this world</p>-->
        <p>
            Very First blog platform for every one, we wll make you 
            skilled on every subject just subscribe to our newsletter
        </p>
        <h4>Did you Know that you can have your own page on protech?</h4>
    </div>
    @else
    <div class="about-user form">
        <p class="fa-1x">{{$user[0]->name}}</p>
        @if($user[0]->userInfo)<p>{{$user[0]->userInfo->about}}@else{{''}}@endif</p>
    </div>
    <div class="contact-user form">
        <p class="fa-1x">Contact <i class="fa fa-phone"></i></p>
        <span class="icon"></span>
        <span class="icon"></span>
        <span class="icon"></span>
    </div>
    @endif
</div>
<p id="copy">PRO TECH ETH COLTD  &copy; 2020</p>
<p>Designed and Developed By <a href="mailto:meharib82@gmail.com">&lt;G+M/&gt;</a></p>
