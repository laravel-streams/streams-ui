<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Support\Facades\Breadcrumbs;

class BreadcrumbsTest extends UiTestCase
{
    public function test_it_renders_breadcrumbs()
    {
        Breadcrumbs::put('/', 'Home');
        Breadcrumbs::put('/about', 'About');

        UI::test('breadcrumbs')
            ->assertSee(['Home', 'About']);
    }
}
