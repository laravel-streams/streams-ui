<?php

namespace Streams\Ui\Tests;

use Streams\Testing\TestCase;

abstract class UiTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \Livewire\LivewireServiceProvider::class,
            \Collective\Html\HtmlServiceProvider::class,
            \Streams\Ui\UiServiceProvider::class,
        ];
    }
}
