<?php

namespace Streams\Ui\Tests\Builders\Concerns;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns\HasText;

class HasTextTest extends UiTestCase
{
    /** @test */
    public function it_can_set_and_get_text(): void
    {
        $builder = new HasTextTestBuilder;

        $builder->text('Hello world');

        $this->assertSame('Hello world', $builder->getText());
    }

    /** @test */
    public function it_evaluates_closure_text(): void
    {
        $builder = new HasTextTestBuilder;

        $builder->text(fn () => sprintf('Hello %s', 'world'));

        $this->assertSame('Hello world', $builder->getText());
    }

    /** @test */
    public function it_returns_null_when_text_is_not_set(): void
    {
        $builder = new HasTextTestBuilder;

        $this->assertNull($builder->getText());
    }
}

class HasTextTestBuilder extends ViewBuilder
{
    use HasText;
}
