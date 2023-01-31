<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Components\Inputs\EmailInput;

class EmailInputTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(EmailInput::class, Livewire::getInstance('email', 1));
    }

    public function test_it_renders()
    {
        $output = Livewire::mount('email', [
            'name' => 'test',
            'placeholder' => 'Example',
        ])->html();

        $this->assertStringContainsString('type="email"', $output);
        $this->assertStringContainsString('placeholder="Example"', $output);
    }
}
