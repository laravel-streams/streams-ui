<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Components\Avatar;
use Streams\Ui\Support\Facades\UI;

class AvatarTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Avatar::class, UI::make('avatar'));
    }

    public function test_it_renders()
    {
        $this->assertIsString(UI::make('avatar')->render());
    }
}
