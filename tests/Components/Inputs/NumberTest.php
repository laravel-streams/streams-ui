<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Components\Inputs\Number;
use Streams\Core\Support\Facades\Streams;

class NumberTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Number::class, UI::make('number'));
    }

    public function test_it_renders()
    {
        $output = UI::make('number', [
            'name' => 'test',
            'placeholder' => 'Example',
        ])->render();

        $this->assertStringContainsString('type="number"', $output);
        $this->assertStringContainsString('placeholder="Example"', $output);
    }
}
