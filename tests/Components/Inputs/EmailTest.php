<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Components\Inputs\Email;
use Streams\Core\Support\Facades\Streams;

class EmailTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Email::class, UI::make('email'));
    }

    public function test_it_renders()
    {
        $output = UI::make('email', [
            'name' => 'test',
            'placeholder' => 'Example',
        ])->render();

        $this->assertStringContainsString('type="email"', $output);
        $this->assertStringContainsString('placeholder="Example"', $output);
    }
}
