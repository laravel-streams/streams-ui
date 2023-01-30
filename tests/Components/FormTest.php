<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Core\Field\Field;
use Streams\Ui\Components\Form;
use Streams\Core\Stream\Stream;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;

class FormTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Form::class, Livewire::getInstance('form', 1));
    }

    public function test_it_renders()
    {
        $this->assertIsString(Livewire::mount('form', [])->html());
    }

    public function test_it_passes_stream()
    {
        $instance = Livewire::getInstance('form', 1);

        $instance->stream = 'films';
        
        $instance->fields = [
            ['field' => 'title'],
        ];

        $instance->booted();

        $this->assertSame('films', $instance->fields[0]['stream']);
    }
}
