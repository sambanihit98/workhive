<?php

namespace App\Providers;

use App\Http\Middleware\AuthPanelUser;
use App\Models\Admin;
use App\Models\Employer;
use App\Models\Job;
use App\Policies\ExportPolicy;
use App\Policies\JobPolicy;
use Filament\Actions\Exports\Models\Export;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //not required if there's multiple panel/model
        //$this->app->bind(Authenticatable::class, Admin::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();

        //------------------------------------
        //exporting from multiple panel (model)
        Export::polymorphicUserRelationship();

        //------------------------------------
        //for admin and employer panel (notification)
        Route::aliasMiddleware('auth.multi', AuthPanelUser::class);

        //------------------------------------
        if ($this->app->environment('production')) {
            // Force Laravel to treat all URLs as HTTPS
            URL::forceScheme('https');

            // Trust Render's proxy headers (X-Forwarded-Proto, etc.)
            Request::setTrustedProxies(
                [$this->app->make('request')->getClientIp()],
                Request::HEADER_X_FORWARDED_ALL
            );
        }
        //------------------------------------

        // if (env('APP_ENV') === 'production') {
        //     URL::forceScheme('https');
        // }
    }

    protected $policies = [
        Job::class => JobPolicy::class,
        Export::class => ExportPolicy::class,
    ];
}
