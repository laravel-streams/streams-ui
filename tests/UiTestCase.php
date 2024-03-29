<?php

namespace Streams\Ui\Tests;

use Streams\Testing\TestCase;

abstract class UiTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \Collective\Html\HtmlServiceProvider::class,
            \Livewire\LivewireServiceProvider::class,
            \Streams\Ui\UiServiceProvider::class,
        ];
    }
}
