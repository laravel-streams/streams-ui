<?php

namespace Streams\Ui\Tests\Builders\Breadcrumbs;

use Streams\Ui\Builders\Builder;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\ViewBuilder;
use Illuminate\Contracts\Support\Htmlable;
use Streams\Ui\Builders\Breadcrumbs\Breadcrumbs;

class BreadcrumbsTest extends UiTestCase
{
    /** @test */
    public function it_can_be_instantiated()
    {
        $breadcrumbs = new Breadcrumbs;

        $this->assertInstanceOf(Builder::class, $breadcrumbs);
        $this->assertInstanceOf(ViewBuilder::class, $breadcrumbs);
        $this->assertInstanceOf(Breadcrumbs::class, $breadcrumbs);
        $this->assertInstanceOf(Htmlable::class, $breadcrumbs);
    }

    /** @test */
    public function it_can_be_instantiated_with_items()
    {
        $items = [
            ['title' => 'Home', 'href' => '/'],
            ['title' => 'About', 'href' => '/about'],
        ];

        $breadcrumbs = new Breadcrumbs($items);

        $this->assertEquals($items, $breadcrumbs->getItems());
    }

    /** @test */
    public function it_can_be_instantiated_with_empty_items()
    {
        $breadcrumbs = new Breadcrumbs([]);

        $this->assertEquals([], $breadcrumbs->getItems());
    }

    /** @test */
    public function it_can_be_made_with_static_method()
    {
        $breadcrumbs = Breadcrumbs::make();

        $this->assertInstanceOf(Breadcrumbs::class, $breadcrumbs);
    }

    /** @test */
    public function it_can_be_made_with_items()
    {
        $items = [
            ['title' => 'Home', 'href' => '/'],
            ['title' => 'Products', 'href' => '/products'],
        ];

        $breadcrumbs = Breadcrumbs::make($items);

        $this->assertEquals($items, $breadcrumbs->getItems());
    }

    /** @test */
    public function it_has_default_view()
    {
        $breadcrumbs = Breadcrumbs::make();

        $this->assertEquals('ui::builders.breadcrumbs', $breadcrumbs->getView());
    }

    /** @test */
    public function it_has_view_identifier()
    {
        $breadcrumbs = Breadcrumbs::make();

        $reflection = new \ReflectionClass($breadcrumbs);
        $property = $reflection->getProperty('viewIdentifier');
        $property->setAccessible(true);

        $this->assertEquals('breadcrumbs', $property->getValue($breadcrumbs));
    }

    /** @test */
    public function it_can_set_items()
    {
        $breadcrumbs = Breadcrumbs::make();

        $items = [
            ['title' => 'Dashboard', 'href' => '/dashboard'],
            ['title' => 'Settings', 'href' => '/settings'],
        ];

        $result = $breadcrumbs->items($items);

        $this->assertSame($breadcrumbs, $result);
        $this->assertEquals($items, $breadcrumbs->getItems());
    }

    /** @test */
    public function it_can_get_items()
    {
        $items = [
            ['title' => 'Home', 'href' => '/'],
        ];

        $breadcrumbs = Breadcrumbs::make($items);

        $this->assertEquals($items, $breadcrumbs->getItems());
    }

    /** @test */
    public function it_returns_empty_array_when_no_items()
    {
        $breadcrumbs = Breadcrumbs::make();

        $this->assertEquals([], $breadcrumbs->getItems());
    }

    /** @test */
    public function it_can_add_item_with_href()
    {
        $breadcrumbs = Breadcrumbs::make();

        $result = $breadcrumbs->addItem('Home', '/');

        $this->assertSame($breadcrumbs, $result);
        $this->assertEquals([
            ['title' => 'Home', 'href' => '/'],
        ], $breadcrumbs->getItems());
    }

    /** @test */
    public function it_can_add_item_without_href()
    {
        $breadcrumbs = Breadcrumbs::make();

        $breadcrumbs->addItem('Current Page');

        $this->assertEquals([
            ['title' => 'Current Page', 'href' => null],
        ], $breadcrumbs->getItems());
    }

    /** @test */
    public function it_can_add_multiple_items()
    {
        $breadcrumbs = Breadcrumbs::make();

        $breadcrumbs
            ->addItem('Home', '/')
            ->addItem('Products', '/products')
            ->addItem('Widget', '/products/widget');

        $expected = [
            ['title' => 'Home', 'href' => '/'],
            ['title' => 'Products', 'href' => '/products'],
            ['title' => 'Widget', 'href' => '/products/widget'],
        ];

        $this->assertEquals($expected, $breadcrumbs->getItems());
    }

    /** @test */
    public function it_can_chain_add_item_calls()
    {
        $breadcrumbs = Breadcrumbs::make()
            ->addItem('Home', '/')
            ->addItem('About', '/about');

        $this->assertInstanceOf(Breadcrumbs::class, $breadcrumbs);
        $this->assertCount(2, $breadcrumbs->getItems());
    }

    /** @test */
    public function it_appends_items_when_adding()
    {
        $breadcrumbs = Breadcrumbs::make([
            ['title' => 'Home', 'href' => '/'],
        ]);

        $breadcrumbs->addItem('About', '/about');

        $this->assertCount(2, $breadcrumbs->getItems());
        $this->assertEquals('About', $breadcrumbs->getItems()[1]['title']);
    }

    /** @test */
    public function it_can_replace_items_with_items_method()
    {
        $breadcrumbs = Breadcrumbs::make([
            ['title' => 'Home', 'href' => '/'],
        ]);

        $breadcrumbs->items([
            ['title' => 'Dashboard', 'href' => '/dashboard'],
        ]);

        $this->assertCount(1, $breadcrumbs->getItems());
        $this->assertEquals('Dashboard', $breadcrumbs->getItems()[0]['title']);
    }

    /** @test */
    public function it_has_configure_method()
    {
        $breadcrumbs = Breadcrumbs::make();

        $result = $breadcrumbs->configure();

        $this->assertSame($breadcrumbs, $result);
    }

    /** @test */
    public function it_calls_configure_on_make()
    {
        $breadcrumbs = new class extends Breadcrumbs
        {
            public bool $configuredCalled = false;

            public function configure(): static
            {
                $this->configuredCalled = true;

                return parent::configure();
            }
        };

        $instance = $breadcrumbs::make();

        $this->assertTrue($instance->configuredCalled);
    }

    /** @test */
    public function it_can_set_html_attributes()
    {
        $breadcrumbs = Breadcrumbs::make();

        $this->assertTrue(method_exists($breadcrumbs, 'htmlAttributes'));
    }

    /** @test */
    public function it_can_get_html_attributes()
    {
        $breadcrumbs = Breadcrumbs::make();

        $this->assertTrue(method_exists($breadcrumbs, 'getHtmlAttributes'));
    }

    /** @test */
    public function it_supports_fluent_interface()
    {
        $breadcrumbs = Breadcrumbs::make()
            ->items([['title' => 'Test', 'href' => '/test']])
            ->addItem('Another', '/another')
            ->configure();

        $this->assertInstanceOf(Breadcrumbs::class, $breadcrumbs);
        $this->assertCount(2, $breadcrumbs->getItems());
    }

    /** @test */
    public function it_preserves_item_structure()
    {
        $breadcrumbs = Breadcrumbs::make();

        $breadcrumbs->addItem('Test Title', '/test-url');

        $items = $breadcrumbs->getItems();

        $this->assertArrayHasKey('title', $items[0]);
        $this->assertArrayHasKey('href', $items[0]);
        $this->assertEquals('Test Title', $items[0]['title']);
        $this->assertEquals('/test-url', $items[0]['href']);
    }

    /** @test */
    public function it_handles_null_href_in_items()
    {
        $breadcrumbs = Breadcrumbs::make();

        $breadcrumbs->addItem('No Link');

        $items = $breadcrumbs->getItems();

        $this->assertNull($items[0]['href']);
    }

    /** @test */
    public function it_can_mix_items_and_add_item()
    {
        $breadcrumbs = Breadcrumbs::make([
            ['title' => 'Home', 'href' => '/'],
        ]);

        $breadcrumbs->addItem('About', '/about');

        $this->assertEquals([
            ['title' => 'Home', 'href' => '/'],
            ['title' => 'About', 'href' => '/about'],
        ], $breadcrumbs->getItems());
    }
}
