<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class AvatarTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('avatar', [
            'src' => '/test/image.png',
        ])->assertSeeHtml('src="/test/image.png"');
    }
}
