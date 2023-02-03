<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Components\Inputs\Color;
use Streams\Core\Support\Facades\Streams;

class ColorTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Color::class, UI::make('color'));
    }

    public function test_it_renders()
    {
        $output = UI::make('color', [
            'name' => 'test',
        ])->render();

        $this->assertStringContainsString('type="color"', $output);
    }
}
