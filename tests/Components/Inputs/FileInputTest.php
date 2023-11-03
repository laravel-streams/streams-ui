<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Components\Inputs\FileInput;

class FileInputTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test(FileInput::class, [
            'name' => 'example',
        ])->assertSeeHtml('type="file"');
    }
}
