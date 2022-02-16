<?php

namespace Wwlh\FeishuSdk;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Config;

class FeiShuProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('feishu', function ($app) {
            $config = [
                'app_id'     => config('feishu.app_id'),
                'app_secret' => config('feishu.app_secret'),
                'verify'     => config('feishu.verify')
            ];

            return new FeiShuClient($config);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [FeiShuClient::class];
    }
}