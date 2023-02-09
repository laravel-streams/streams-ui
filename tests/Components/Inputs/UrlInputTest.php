<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class UrlInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('url', [
            'name' => 'example',
        ])->assertSeeHtml('type="url"');
    }
}
