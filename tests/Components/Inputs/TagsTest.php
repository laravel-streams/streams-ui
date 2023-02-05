<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Components\Inputs\Tags;
use Streams\Core\Support\Facades\Streams;

class TagsTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Tags::class, UI::make('tags'));
    }

    public function test_it_renders()
    {
        $output = UI::make('tags', [
            'name' => 'test',
            'placeholder' => 'Example',
        ])->render();

        $this->assertStringContainsString('type="text"', $output);
        $this->assertStringContainsString('placeholder="Example"', $output);
    }
}
