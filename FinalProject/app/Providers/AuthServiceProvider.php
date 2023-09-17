<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use App\Models\User;
use App\Models\Action;
use App\Models\Comment;
use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
use Laravel\Sanctum\Sanctum;
use App\Policies\ActionPolicy;
use App\Policies\CommentPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use HasFactory, Notifiable;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Post::class => PostPolicy::class,
        User::class => UserPolicy::class,
        Action::class => ActionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //Comment Gates are written here. Other Gates are grouped together with their corresponding Policies.
        Gate::define('comment-update',function(User $user , Comment $comment){
            return $user->id == $comment->user_id;
        });
        Gate::define('comment-delete',function(User $user , Comment $comment){
            return $user->id == $comment->user_id;
        });
        Gate::define('comment-create',function(User $user ,$userID){
            return $user->id == $userID;
        });
    }
}
