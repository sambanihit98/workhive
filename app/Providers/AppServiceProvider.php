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
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //not required if there's multiple panel/model
        //$this->app->bind(Authenticatable::class, Admin::class);

        URL::macro(
            'alternateHasCorrectSignature',
            function (Request $request, $absolute = true, array $ignoreQuery = []) {
                $ignoreQuery[] = 'signature';

                $absoluteUrl = url($request->path());
                $url = $absolute ? $absoluteUrl : '/' . $request->path();

                $queryString = collect(explode('&', (string) $request
                    ->server->get('QUERY_STRING')))
                    ->reject(fn($parameter) => in_array(Str::before($parameter, '='), $ignoreQuery))
                    ->join('&');

                $original = rtrim($url . '?' . $queryString, '?');

                // Use the application key as the HMAC key
                $key = config('app.key'); // Ensure app.key is properly set in .env

                if (empty($key)) {
                    throw new \RuntimeException('Application key is not set.');
                }

                $signature = hash_hmac('sha256', $original, $key);
                return hash_equals($signature, (string) $request->query('signature', ''));
            }
        );

        URL::macro('alternateHasValidSignature', function (Request $request, $absolute = true, array $ignoreQuery = []) {
            return URL::alternateHasCorrectSignature($request, $absolute, $ignoreQuery)
                && URL::signatureHasNotExpired($request);
        });

        Request::macro('hasValidSignature', function ($absolute = true, array $ignoreQuery = []) {
            return URL::alternateHasValidSignature($this, $absolute, $ignoreQuery);
        });
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
        // if (env('APP_ENV') === 'production') {
        //     URL::forceScheme('https');
        // }
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        //------------------------------------
    }

    protected $policies = [
        Job::class => JobPolicy::class,
        Export::class => ExportPolicy::class,
    ];
}
