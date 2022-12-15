<?php

namespace App\Providers;

use App\Models\Cabinet;
use App\Models\Category;
use App\Models\Help;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Work;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/panel/help';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        //Binding id
        Route::bind('cabinet', function (int $value) {
            return app(Cabinet::class)->viewOneItem($value);
        });
        Route::bind('category', function (int $value) {
            return app(Category::class)->viewOneItem($value);
        });
        Route::bind('status', function (int $value) {
            return app(Status::class)->viewOneItem($value);
        });
        Route::bind('priority', function (int $value) {
            return app(Priority::class)->viewOneItem($value);
        });
        Route::bind('work', function (int $value) {
            return app(Work::class)->viewOneItem($value);
        });
        Route::bind('help', function (int $value) {
            return app(Help::class)->viewOneItem($value);
        });
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
