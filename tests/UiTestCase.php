<?php

namespace Streams\Ui\Tests;

use Streams\Testing\TestCase;

abstract class UiTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('view:clear');
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
