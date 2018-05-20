<?php

namespace App\Providers;

use App\Meeting;
use App\Policies\MeetingPolicy;
use App\Policies\UploadPolicy;
use App\Policies\PostPolicy;
use App\Post;
use App\Upload;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Post::class => PostPolicy::class,
        Meeting::class => MeetingPolicy::class,
        Report::class => ReportPolicy::class,
        Upload::class => UploadPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
