<?php

namespace App\Providers;

use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
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
        Scramble::configure()
        ->withDocumentTransformers(function (OpenApi $openApi) {
            $openApi->secure(
                SecurityScheme::http('bearer')
            );
        });

        Scramble::registerApi('v1', [
            'title' => 'Sima Orbit V2 API Documentation',
            'description' => 'API documentation for Sima Orbit V2 application.',
            'version' => '1.0.0',
        ])->expose(
            ui: '/docs/api',
            document: '/docs/api.json'
        );

    }
}
