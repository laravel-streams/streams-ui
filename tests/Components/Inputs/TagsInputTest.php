<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Components\Inputs\TagsInput;

class TagsInputTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(TagsInput::class, Livewire::getInstance('tags', 1));
    }

    public function test_it_renders()
    {
        $output = Livewire::mount('tags', [
            'name' => 'test',
            'placeholder' => 'Example',
        ])->html();

        //$this->assertStringContainsString('type="text"', $output);
        //$this->assertStringContainsString('placeholder="Example"', $output);
    }
}
