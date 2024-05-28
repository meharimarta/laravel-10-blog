<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('member-approve',function($user) {
           return $user->id === 1 
               ? Response::allow() 
               : Response::deny('You are not allowed to perform this action.');
        });
        Gate::define('banned',function($user) {
           return $user->banned === 1 ? Response::deny('You are not authorized.') : Response::allow(); 
        });

        //
    }
}
