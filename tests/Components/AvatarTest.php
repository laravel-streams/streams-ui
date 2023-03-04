<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;

class AvatarTest extends UiTestCase
{
    public function test_it_renders()
    {
        UI::test('avatar', [
            'src' => '/test/image.png',
        ])->assertSee('src="/test/image.png"');
    }
}
