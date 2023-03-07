<?php

namespace Streams\Ui\Tests\Support;

use Streams\Core\Stream\Stream;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Component;
use Streams\Core\Support\Workflow;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\View\ViewTemplate;
use Streams\Ui\Components\Traits\HasStream;

class ComponentTest extends UiTestCase
{
    public function test_it_renders_to_string()
    {
        UI::component('test-component', ComponentTestComponent::class);

        $testable = UI::test('test-component', [
            'text' => 'Test',
            'stream' => 'films',
        ])->assertSee('Test');

        $this->assertStringContainsString('Test', (string) $testable->component);
    }

    public function test_it_renders_view_templates()
    {
        $view = ViewTemplate::path('<div>View: {{ $component->text }}</div>');
    
        UI::component('test-component', ComponentTestComponent::class);

        UI::test('test-component', [
            'text' => 'Test',
            'stream' => 'films',
            'template' => $view,
        ])->assertSee('View: Test');
    }

    public function test_it_renders_inline_templates()
    {
        UI::component('test-component', ComponentTestComponent::class);

        UI::test('test-component', [
            'text' => 'Test',
            'stream' => 'films',
        ])->assertSee('Inline: Test');
    }

    public function test_it_supports_layouts()
    {
        $layout = ViewTemplate::path('<div>ADMIN: {!! $slot !!}</div>');

        UI::component('test-component', ComponentTestComponent::class);

        UI::test('test-component', [
            'text' => 'Test',
            'stream' => 'films',
            'layout' => $layout,
        ])->assertSee(['ADMIN:', 'Inline: Test']);
    }

    public function test_it_supports_builders()
    {
        UI::component('test-component', ComponentTestComponent::class);
        
        $component = UI::make('test-component', [
            'builder' => ComponentTestComponentBuilder::class,
        ]);

        $this->assertSame(123, $component->number);
    }
}

class ComponentTestComponent extends Component
{
    use HasStream;

    public ?string $builder = null;
    
    public ?string $text = null;

    public ?int $number = null;

    public string $template = <<<'blade'
        <div>
            Inline: {{ $component->text }}
        </div>
    blade;
}

class ComponentTestComponentBuilder extends Workflow
{
    public array $steps = [
        'set_number' => __CLASS__ . '@setNumber',
    ];

    public function setNumber(Component $component)
    {
        $component->number = 123;
    }
}
