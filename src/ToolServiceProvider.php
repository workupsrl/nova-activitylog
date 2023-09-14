<?php

namespace Workup\Nova\ActivityLog;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\ServiceProvider;
use Spatie\ActivityLog\Models\Activity;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/nova-activitylog.php' => config_path('nova-activitylog.php'),
        ], 'config');

        $this->mergeConfigFrom(__DIR__ . '/../config/nova-activitylog.php', 'nova-activitylog');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nova-activitylog');

        $this->app->booted(function () {
            // 记录操作者 IP
            // @see https://github.com/spatie/laravel-activitylog/issues/39
            config('activitylog.activity_model')::saving(function (Activity $activity) {
                $activity->properties = $activity->properties->put('ip', request()->ip());
            });

            Nova::resources([
                config('nova-activitylog.resource'),
            ]);
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            activity()->enableLogging();
        });
    }

    /**
     * Register the tool's routes.
     */
    protected function routes()
    {
    }

    /**
     * Register any application services.
     */
    public function register()
    {
    }
}
