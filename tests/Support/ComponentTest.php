<?php

namespace Streams\Ui\Tests\Support;

use Livewire\Livewire;
use Streams\Core\Stream\Stream;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Component;

class ComponentTest extends UiTestCase
{
    public function test_it_supports_streams()
    {
        Livewire::component('test-component', ComponentTestComponent::class);

        $stream = Livewire::test('test-component')
            ->set('stream', 'films')
            ->instance()
            ->stream();

        $this->assertInstanceOf(Stream::class, $stream);
    }
}

class ComponentTestComponent extends Component
{
    public ?string $text = null;

    public string $template = <<<'blade'
        <div>
            <button>{{ $component->text }}</button>
        </div>
    blade;
}
