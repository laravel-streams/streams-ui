<?php

namespace Streams\Ui\Tests;

use Streams\Ui\Support\Component;
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Testing\TestableComponent;

class UiManagerTest extends UiTestCase
{
    public function test_it_registers_components()
    {
        $this->assertFalse(UI::exists('test'));

        UI::component('test', UiManagerTestComponent::class);

        $this->assertTrue(UI::exists('test'));

        UI::test('test', ['tag' => 'h2'])->assertSee(['Test Component', 'h2']);

        $this->expectException(\Exception::class);

        UI::make('nope');
    }

    public function test_it_registers_only_once()
    {
        $count = count(UI::getComponents());

        UI::component('test', UiManagerTestComponent::class);
        UI::component('test', UiManagerTestComponent::class);

        $this->assertTrue($count+1 === count(UI::getComponents()));
    }

    public function test_it_can_make_anonymous_components()
    {
        $component = UI::make(UiManagerTestComponent::class, ['tag' => 'h3']);

        (new TestableComponent($component))->assertSee('Test Component');
    }

    public function test_it_supports_array_configuration()
    {
        UI::component('test', UiManagerTestComponent::class);
        UI::component('test.h4', [
            'component' => 'test',
            'tag' => 'h4',
        ]);

        UI::test('test.h4')->assertSee(['Test Component', 'h4']);
    }
}

class UiManagerTestComponent extends Component
{
    public string $tag = 'h1';

    public string $template = <<<'blade'
        <div>
            <{{ $component->tag }}>{{ $slot ?? 'Test Component' }}</{{ $component->tag }}>
        </div>
        blade;
}
