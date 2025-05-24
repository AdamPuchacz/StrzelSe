<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Competition;
use App\Models\ForumTopic;
use App\Policies\CommentPolicy;
use App\Policies\CompetitionPolicy;
use App\Policies\TopicPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        ForumTopic::class => TopicPolicy::class,
        Comment::class => CommentPolicy::class,
        Competition::class => CompetitionPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

    }
}
