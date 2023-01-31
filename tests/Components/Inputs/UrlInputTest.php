<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Components\Inputs\UrlInput;

class UrlInputTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(UrlInput::class, Livewire::getInstance('url', 1));
    }

    public function test_it_renders()
    {
        $output = Livewire::mount('url', [
            'name' => 'test',
            'placeholder' => 'Example',
        ])->html();

        $this->assertStringContainsString('type="url"', $output);
        $this->assertStringContainsString('placeholder="Example"', $output);
    }
}
