<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class FileInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('file', [
            'name' => 'example',
        ])->assertSeeHtml('type="file"');
    }
}
