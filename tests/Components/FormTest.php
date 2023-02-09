<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class FormTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('form', [
            'action' => '/test/url',
        ])->assertSeeHtml('action="/test/url"');
    }
}
