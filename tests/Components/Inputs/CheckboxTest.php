<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Components\Inputs\Checkbox;

class CheckboxTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Checkbox::class, UI::make('checkbox'));
    }

    public function test_it_renders()
    {
        $output = UI::make('checkbox', [
            'name' => 'test',
            'label' => 'Example',
        ])->render();

        $this->assertStringContainsString('type="checkbox"', $output);
        $this->assertStringContainsString('Example', $output);
    }
}
