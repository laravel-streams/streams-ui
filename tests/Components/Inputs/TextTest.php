<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Components\Inputs\Text;
use Streams\Core\Support\Facades\Streams;

class TextTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Text::class, UI::make('text'));
    }

    public function test_it_renders()
    {
        $output = UI::make('text', [
            'name' => 'test',
            'placeholder' => 'Example',
        ])->render();

        $this->assertStringContainsString('type="text"', $output);
        $this->assertStringContainsString('placeholder="Example"', $output);
    }
}
