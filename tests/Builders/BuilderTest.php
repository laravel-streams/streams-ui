<?php

namespace Streams\Ui\Tests\Builders;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Builder;

class BuilderTest extends UiTestCase
{
    protected function getTestBuilder(): TestBuilder
    {
        return new TestBuilder();
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $builder = $this->getTestBuilder();

        $this->assertInstanceOf(Builder::class, $builder);
        $this->assertInstanceOf(TestBuilder::class, $builder);
    }

    /** @test */
    public function it_has_conditionable_trait()
    {
        $builder = $this->getTestBuilder();

        $result = $builder->when(true, function ($builder) {
            $builder->testProperty = 'modified';
        });

        $this->assertEquals('modified', $builder->testProperty);
        $this->assertSame($builder, $result);
    }

    /** @test */
    public function it_has_conditionable_unless()
    {
        $builder = $this->getTestBuilder();

        $result = $builder->unless(false, function ($builder) {
            $builder->testProperty = 'modified';
        });

        $this->assertEquals('modified', $builder->testProperty);
        $this->assertSame($builder, $result);
    }

    /** @test */
    public function it_has_tappable_trait()
    {
        $builder = $this->getTestBuilder();

        $result = $builder->tap(function ($builder) {
            $builder->testProperty = 'tapped';
        });

        $this->assertEquals('tapped', $builder->testProperty);
        $this->assertSame($builder, $result);
    }

    /** @test */
    public function it_evaluates_closures()
    {
        $builder = $this->getTestBuilder();

        $value = $builder->evaluate(fn() => 'evaluated');

        $this->assertEquals('evaluated', $value);
    }

    /** @test */
    public function it_returns_non_closure_values_directly()
    {
        $builder = $this->getTestBuilder();

        $this->assertEquals('string', $builder->evaluate('string'));
        $this->assertEquals(123, $builder->evaluate(123));
        $this->assertEquals(['array'], $builder->evaluate(['array']));
    }

    /** @test */
    public function it_can_inject_dependencies_into_closures()
    {
        $builder = $this->getTestBuilder();

        $value = $builder->evaluate(
            fn($foo) => $foo,
            ['foo' => 'bar']
        );

        $this->assertEquals('bar', $value);
    }

    /** @test */
    public function it_can_be_configured()
    {
        TestBuilder::configureUsing(function (TestBuilder $builder) {
            $builder->testProperty = 'configured';
        });

        $builder = TestBuilder::make();

        $this->assertEquals('configured', $builder->testProperty);
    }

    /** @test */
    public function it_supports_configuration_scope()
    {
        $result = TestBuilder::configureUsing(
            function (TestBuilder $builder) {
                $builder->testProperty = 'scoped';
            },
            function () {
                $builder = TestBuilder::make();
                return $builder->testProperty;
            }
        );

        $this->assertEquals('scoped', $result);

        // Outside scope should not have the configuration
        $builder = TestBuilder::make();
        $this->assertNotEquals('scoped', $builder->testProperty);
    }

    /** @test */
    public function it_supports_deferred_configuration()
    {
        TestBuilder::configureUsing(
            function (TestBuilder $builder) {
                $builder->testProperty = 'deferred';
            },
            defer: true
        );

        $builder = TestBuilder::make();

        $this->assertEquals('deferred', $builder->testProperty);
    }

    /** @test */
    public function it_has_memory_trait()
    {
        $builder = $this->getTestBuilder();

        // Test once method
        $counter = 0;
        $result1 = $builder->once('test', function () use (&$counter) {
            $counter++;
            return 'value';
        });
        $result2 = $builder->once('test', function () use (&$counter) {
            $counter++;
            return 'different';
        });

        $this->assertEquals('value', $result1);
        $this->assertEquals('value', $result2);
        $this->assertEquals(1, $counter);
    }

    /** @test */
    public function it_fires_callbacks()
    {
        $builder = $this->getTestBuilder();

        $callbackFired = false;
        $builder->on('testEvent', function () use (&$callbackFired) {
            $callbackFired = true;
        });

        $builder->fire('testEvent');

        $this->assertTrue($callbackFired);
    }

    /** @test */
    public function it_fires_callbacks_with_parameters()
    {
        $builder = $this->getTestBuilder();

        $receivedValue = null;
        $builder->on('testEvent', function ($value) use (&$receivedValue) {
            $receivedValue = $value;
        });

        $builder->fire('testEvent', ['test-value']);

        $this->assertEquals('test-value', $receivedValue);
    }
}

// Test implementation of Builder
class TestBuilder extends Builder
{
    public string $testProperty = 'default';
}
