<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Components\Inputs\Textarea;

class TextareaTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Textarea::class, UI::make('textarea'));
    }

    public function test_it_renders()
    {
        $output = UI::make('textarea', [
            'name' => 'test',
        ])->render();

        $this->assertStringContainsString('<textarea', $output);
    }
}
