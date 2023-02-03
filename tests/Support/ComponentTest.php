<?php

namespace Streams\Ui\Tests\Support;

use Streams\Core\Stream\Stream;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Components\Button;
use Streams\Ui\Support\Component;
use Streams\Core\View\ViewTemplate;
use Streams\Core\Field\Decorator\StringDecorator;

class ComponentTest extends UiTestCase
{
    public function test_it_is_arrayable()
    {
        $this->assertIsArray((new ComponentTestComponent([
            'tile' => 'Films',
        ]))->toArray());
    }

    public function test_it_supports_streams()
    {
        $this->assertSame('films', (new ComponentTestComponent([
            'stream' => 'films',
        ]))->stream()->handle);
    }

    public function test_it_renders()
    {
        $test = '<button>Films</button>';

        $component = (new ComponentTestComponent([
            'text' => 'Films',
        ]));

        $id = $component->id;
        $name = $component->name();

        $this->assertStringContainsString($test, $rendered = $component->render());
        $this->assertStringContainsString("ui:id=\"{$id}\"", $rendered);
        $this->assertStringContainsString("ui:name=\"{$name}\"", $rendered);

        $component->template = ViewTemplate::path($component->template);
        
        $this->assertStringContainsString($test, $rendered = $component->render());
        $this->assertStringContainsString("ui:id=\"{$id}\"", $rendered);
        $this->assertStringContainsString("ui:name=\"{$name}\"", $rendered);
    }
    
    public function test_it_can_return_its_name(Type $var = null)
    {
        $component = new ComponentTestComponent;

        $this->assertSame('component-test-component', $component->name());
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
