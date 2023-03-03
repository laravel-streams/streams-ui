<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class InputTest extends UiTestCase
{
    public function test_it_supports_stream_fields()
    {
        $input = UI::make('input', [
            'stream' => 'films',
            'field' => 'title',
        ]);

        $this->assertEquals('title', $input->field()->handle);
    }
}
