<?php

namespace Streams\Ui\Tests\Support;

use ArrayAccess;
use Tests\TestCase;
use Streams\Ui\Support\Component;
use Illuminate\Support\Collection;
use Streams\Core\Field\Value\Value;
use Streams\Core\Field\Value\NumberValue;
use Streams\Core\Support\Traits\Prototype;

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
