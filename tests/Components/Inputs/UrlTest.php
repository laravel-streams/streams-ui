<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Components\Inputs\Url;
use Streams\Core\Support\Facades\Streams;

class UrlTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Url::class, UI::make('url'));
    }

    public function test_it_renders()
    {
        $output = UI::make('url', [
            'name' => 'test',
            'placeholder' => 'Example',
        ])->render();

        $this->assertStringContainsString('type="url"', $output);
        $this->assertStringContainsString('placeholder="Example"', $output);
    }
}
