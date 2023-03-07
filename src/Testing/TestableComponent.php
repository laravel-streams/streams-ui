<?php

namespace Streams\Ui\Testing;

use Illuminate\Support\Arr;
use Illuminate\Testing\Assert;
use Streams\Ui\Support\Component;

class TestableComponent
{
    protected ?string $rendered = null;

    public function __construct(public Component $component)
    {
    }

    public function render(array $payload = [])
    {
        $this->rendered = html_entity_decode($this->component->render($payload));

        return $this;
    }

    public function assertSet($name, $value, $strict = true)
    {
        $actual = $this->component->{$name};

        $strict
            ? Assert::assertSame($value, $actual)
            : Assert::assertEquals($value, $actual);

        return $this;
    }

    public function assertNotSet($name, $value, $strict = true)
    {
        $actual = $this->component->{$name};

        $strict
            ? Assert::assertNotSame($value, $actual)
            : Assert::assertNotEquals($value, $actual);

        return $this;
    }

    public function assertCount($name, $value)
    {
        Assert::assertCount($value, $this->component->{$name});

        return $this;
    }

    public function assertSee($values)
    {
        $this->renderIfNotRendered();

        foreach (Arr::wrap($values) as $value) {
            Assert::assertStringContainsString($value, $this->rendered);
        }

        return $this;
    }

    public function assertNotSee($values)
    {
        $this->renderIfNotRendered();

        foreach (Arr::wrap($values) as $value) {
            Assert::assertStringNotContainsString($value, $this->rendered);
        }

        return $this;
    }

    protected function renderIfNotRendered()
    {
        if (!$this->rendered) {
            $this->render();
        }
    }

    public function __get($name)
    {
        return $this->component->{$name};
    }

    public function __call($method, $parameters)
    {
        return $this->component->{$method}(...$parameters);
    }
}
