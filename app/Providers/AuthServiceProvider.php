<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;

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

        Gate::define('post-update',function($user,$post){

          return   $user->id === $post->user_id;
        });


        Gate::define('post-delete',function($user,$post){
            
            return   $user->id === $post->user_id;

            // return   $user->id === $post->user_id  ? Response::allow()
            //                         : Response::deny('You can't deleted');

          });


    }
}
