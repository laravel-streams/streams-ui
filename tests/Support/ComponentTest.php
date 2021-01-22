<?php

namespace Streams\Ui\Tests\Support;

use Tests\TestCase;
use Streams\Ui\Support\Component;
use Illuminate\Support\Collection;

class ComponentTest extends TestCase
{

    public function testCanInstantiate()
    {
        $component = new TestComponent();

        $this->assertStringContainsString('class="test"', (string) $component->render());
    }
}

class TestComponent extends Component
{
    protected function initializePrototype(array $attributes)
    {
        return parent::initializePrototype(array_merge([
            'template' => 'ui::tests/component',
            'component' => 'input',
            'classes' => ['test'],
            'attributes' => [],
            'data' => new Collection(),
        ], $attributes));
    }
}
