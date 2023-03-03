<?php

namespace Streams\Ui\Testing;

use Illuminate\Support\Arr;
use Illuminate\Testing\Assert;
use Streams\Ui\Support\Component;

class TestableComponent
{
    protected string $rendered;

    public function __construct(protected Component $component)
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
        foreach (Arr::wrap($values) as $value) {
            Assert::assertStringContainsString($value, $this->rendered);
        }

        return $this;
    }

    public function assertNotSee($values)
    {
        foreach (Arr::wrap($values) as $value) {
            Assert::assertStringNotContainsString($value, $this->rendered);
        }

        return $this;
    }

    public function __call($method, $parameters)
    {
        return $this->component->{$method}(...$parameters);
    }
}
