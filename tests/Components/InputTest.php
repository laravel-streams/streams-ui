<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Components\Input;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;

class InputTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Input::class, UI::make('input'));
    }

    public function test_it_renders()
    {
        $field = Streams::make('films')->fields->get('title');

        $this->assertIsString(UI::make('input', [
            'field' => $field,
        ])->render());
    }
}
