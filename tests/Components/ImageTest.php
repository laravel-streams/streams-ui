<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class ImageTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('image', [
            'src' => '/test/image.png',
        ])->assertSeeHtml('src="/test/image.png"');
    }
}
