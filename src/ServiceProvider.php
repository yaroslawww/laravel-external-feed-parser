<?php

namespace ExternalFeedParser;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/external-feed-parser.php' => config_path('external-feed-parser.php'),
            ], 'config');


            $this->commands([
                //
            ]);
        }
    }

    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/external-feed-parser.php', 'external-feed-parser');

        $this->app->bind('external-feed-parser', function ($app) {
            return new FeedParseManager($app);
        });
    }
}
