<?php

namespace Streams\Ui\Tests;

use Streams\Testing\TestCase;

abstract class UiTestCase extends TestCase
{
    private static bool $compiledViewsCleared = false;

    protected function setUp(): void
    {
        parent::setUp();

        // Compiled Blade is cached in vendor/streams/testing and keyed only by
        // the view's mtime. A view compiled before a directive (e.g. @svg)
        // was registered stays stale, so start each process from a clean cache.
        if (! self::$compiledViewsCleared) {
            foreach (glob(config('view.compiled').'/*.php') ?: [] as $file) {
                @unlink($file);
            }

            self::$compiledViewsCleared = true;
        }
    }

    protected function getPackageProviders($app)
    {
        return [
            \BladeUI\Icons\BladeIconsServiceProvider::class,
            \BladeUI\Heroicons\BladeHeroiconsServiceProvider::class,
            \Livewire\LivewireServiceProvider::class,
            \Streams\Ui\UiServiceProvider::class,
        ];
    }
}
