<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        // Creating Gate to authorize assigning task to user
        Gate::define('assign-task', function (User $user) {
            return $user->role == 'admin'
                ? Response::allow()
                : Response::deny('You do not have permission to assign tasks.');
        });

        // Creating Gate to authorize removing task assignment from a user
        Gate::define('remove-task', function (User $user) {
            return $user->role == 'admin'
                ? Response::allow()
                : Response::deny('You do not have permission to remove this task.');
        });

        // Updating task status
        Gate::define('update-task-status', function (User $user, $task) {
            return $user->role == 'admin' || $user->role == 'super-admin' || $user->tasks()->where('tasks.id', $task->id)->exists()
                ? Response::allow()
                : Response::deny('You do not have permission to update this task.');
        });
    }
}
