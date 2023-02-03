<?php

namespace Streams\Ui\Tests;

use Streams\Testing\TestCase;
use Streams\Ui\UiServiceProvider;
use Collective\Html\HtmlServiceProvider;

abstract class UiTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [UiServiceProvider::class];
    }
}
