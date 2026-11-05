<?php

namespace Streams\Ui\Tests;

use Streams\Testing\TestCase;

abstract class UiTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \Livewire\LivewireServiceProvider::class,
            \BladeUI\Icons\BladeIconsServiceProvider::class,
            \BladeUI\Heroicons\BladeHeroiconsServiceProvider::class,
            \Streams\Ui\UiServiceProvider::class,
        ];
    }
}
