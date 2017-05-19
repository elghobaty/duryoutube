<?php namespace App\Providers;

use App\Youtube\Youtube;
use Illuminate\Support\ServiceProvider;
use App\Youtube\YouTubeAPIServiceProviderInterface;

class YoutubeServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(YouTubeAPIServiceProviderInterface::class, function () {
            return new Youtube(config('youtube.KEY'));
        });
    }
}
