<?php

namespace Streams\Ui\Support\Macros;

use Streams\Ui\Tests\UiTestCase;
use Streams\Core\Support\Facades\Streams;

class FieldInputTest extends UiTestCase
{
    public function test_it_returns_field_inputs()
    {
        $this->assertInstanceOf(
            \Livewire\Response::class,
            Streams::make('films')->fields->get('title')->input()
        );
    }
}
