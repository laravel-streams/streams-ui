<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;

class InputTest extends UiTestCase
{
    public function test_it_supports_stream_fields()
    {
        $input = Livewire::getInstance('input', 1);

        $input->stream = 'films';
        $input->field = 'title';
        
        $this->assertEquals('title', $input->field()->handle);
    }
}
