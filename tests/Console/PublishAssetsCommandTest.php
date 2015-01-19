<?php
namespace Tests\Console;

use FloatingPoint\Stylist\Facades\Stylist;
use Tests\TestCase;

class PublishAssetsCommandTest extends TestCase
{
    public function testAssetPublishing()
    {
        $this->app['files']->cleanDirectory(public_path());

        // Setup our lisener that will discover our available themes and return the paths
        $this->app['events']->listen('stylist.publishing', function() {
            return Stylist::discover(__DIR__.'/../Stubs/Themes');
        });

        $artisan = $this->app->make('Illuminate\Contracts\Console\Kernel');

        // Action
        $artisan->call('stylist:publish');

        // Assert
        $this->assertTrue($this->app['files']->exists(public_path('themes/child-theme')));
        $this->assertFalse($this->app['files']->exists(public_path('themes/parent-theme')));
    }
}
