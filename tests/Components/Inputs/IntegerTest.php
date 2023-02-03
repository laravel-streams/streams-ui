<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Components\Inputs\Integer;

class IntegerTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Integer::class, UI::make('integer'));
    }

    public function test_it_renders()
    {
        $output = UI::make('integer', [
            'name' => 'test',
            'placeholder' => 'Example',
        ])->render();

        $this->assertStringContainsString('type="number"', $output);
        $this->assertStringContainsString('placeholder="Example"', $output);
    }
}
