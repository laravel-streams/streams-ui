<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class TagsInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('tags', [
            'name' => 'example',
        ])->assertSeeHtml('type="text"');
    }
}
