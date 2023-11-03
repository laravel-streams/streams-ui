<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Components\Breadcrumbs;
use Streams\Ui\Support\Facades\Breadcrumbs as BreadcrumbsFacade;

class BreadcrumbsTest extends UiTestCase
{
    public function test_it_renders_breadcrumbs()
    {
        BreadcrumbsFacade::put('/', 'Home');
        BreadcrumbsFacade::put('/about', 'About');

        Livewire::test(Breadcrumbs::class)
            ->assertSee(['Home', 'About']);
    }
}
