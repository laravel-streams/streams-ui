<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Components\Inputs\Decimal;

class DecimalTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Decimal::class, UI::make('decimal'));
    }

    public function test_it_renders()
    {
        $output = UI::make('decimal', [
            'name' => 'test',
            'placeholder' => 'Example',
        ])->render();

        $this->assertStringContainsString('type="number"', $output);
        $this->assertStringContainsString('placeholder="Example"', $output);
    }
}
