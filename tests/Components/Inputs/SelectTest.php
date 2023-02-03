<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Components\Inputs\Select;
use Streams\Core\Support\Facades\Streams;

class SelectTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Select::class, UI::make('select'));
    }

    public function test_it_renders()
    {
        $output = UI::make('select', [
            'name' => 'test',
        ])->render();

        $this->assertStringContainsString('<select', $output);
    }
}
