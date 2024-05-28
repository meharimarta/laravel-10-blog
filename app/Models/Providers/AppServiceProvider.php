<?php

namespace App\Providers;
use App\User;
use App\blog;
use App\Notification;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View()->composer('partials.sidemenu',function($view){
            $view->with('trashes',blog::where('user_id',Auth::user()->id)->onlyTrashed()->count());
            $view->with('notifications',Notification::where('to_user_id',Auth::user()->id)->where('seen',0)->count()); 
            $view->with('user_picture',User::where('id',Auth::user()->id)->get('profile_picture'));
        });
        //cusum email verification template
//        VerifyEmail::toMailUsing(function($notifiable,$url) {
////            $vrerifyUrl = $this->verificationUrl($notifiable);
//            
//            return (new MailMessage) 
//                ->subject('verify your email address')
//                ->markdown('mail.verifyEmail',['url'=>$url]);
//        });
    }
}
