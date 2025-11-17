<?php

namespace Streams\Ui\Tests\Builders;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Builder;
use Streams\Ui\Builders\ViewBuilder;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Support\Htmlable;

class ViewBuilderTest extends UiTestCase
{
    protected function getTestViewBuilder(): TestViewBuilder
    {
        return new TestViewBuilder();
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $builder = $this->getTestViewBuilder();

        $this->assertInstanceOf(Builder::class, $builder);
        $this->assertInstanceOf(ViewBuilder::class, $builder);
        $this->assertInstanceOf(Htmlable::class, $builder);
    }

    /** @test */
    public function it_can_set_and_get_view()
    {
        $builder = $this->getTestViewBuilder();
        
        $result = $builder->view('ui::test-view');

        $this->assertSame($builder, $result);
        $this->assertEquals('ui::test-view', $builder->getView());
    }

    /** @test */
    public function it_can_set_view_with_data()
    {
        $builder = $this->getTestViewBuilder();
        
        $builder->view('ui::test-view', ['foo' => 'bar']);

        $this->assertEquals('ui::test-view', $builder->getView());
    }

    /** @test */
    public function it_evaluates_closure_views()
    {
        $builder = $this->getTestViewBuilder();
        
        $builder->view(fn() => 'ui::dynamic-view');

        $this->assertEquals('ui::dynamic-view', $builder->getView());
    }

    /** @test */
    public function it_returns_early_when_view_is_null()
    {
        $builder = $this->getTestViewBuilder();
        
        $result = $builder->view(null);

        $this->assertSame($builder, $result);
    }

    /** @test */
    public function it_uses_default_view_when_no_view_is_set()
    {
        $builder = $this->getTestViewBuilder();
        
        $builder->defaultView('ui::default-view');

        $this->assertEquals('ui::default-view', $builder->getView());
    }

    /** @test */
    public function it_evaluates_closure_default_views()
    {
        $builder = $this->getTestViewBuilder();
        
        $builder->defaultView(fn() => 'ui::dynamic-default');

        $this->assertEquals('ui::dynamic-default', $builder->getView());
    }

    /** @test */
    public function it_can_set_view_data()
    {
        $builder = $this->getTestViewBuilder();
        
        $result = $builder->viewData(['foo' => 'bar', 'baz' => 'qux']);

        $this->assertSame($builder, $result);
    }

    /** @test */
    public function it_merges_view_data()
    {
        $builder = $this->getTestViewBuilder();
        
        $builder->viewData(['foo' => 'bar']);
        $builder->viewData(['baz' => 'qux']);

        $viewData = $builder->getViewData();
        
        $this->assertArrayHasKey('foo', $viewData);
        $this->assertArrayHasKey('baz', $viewData);
        $this->assertEquals('bar', $viewData['foo']);
        $this->assertEquals('qux', $viewData['baz']);
    }

    /** @test */
    public function it_renders_view()
    {
        $builder = $this->getTestViewBuilder();
        $builder->view('ui::test-view');

        $view = $builder->render();

        $this->assertInstanceOf(View::class, $view);
    }

    /** @test */
    public function it_renders_with_view_identifier()
    {
        $builder = new TestViewBuilderWithIdentifier();
        $builder->view('ui::test-view');

        $view = $builder->render();
        $data = $view->getData();

        $this->assertArrayHasKey('testBuilder', $data);
        $this->assertSame($builder, $data['testBuilder']);
    }

    /** @test */
    public function it_renders_with_attributes()
    {
        $builder = $this->getTestViewBuilder();
        $builder->view('ui::test-view');

        $view = $builder->render();
        $data = $view->getData();

        $this->assertArrayHasKey('attributes', $data);
    }

    /** @test */
    public function it_renders_with_public_methods()
    {
        $builder = $this->getTestViewBuilder();
        $builder->view('ui::test-view');

        $view = $builder->render();
        $data = $view->getData();

        // Check that public methods are exposed as closures
        $this->assertArrayHasKey('getView', $data);
        $this->assertInstanceOf(\Closure::class, $data['getView']);
    }

    /** @test */
    public function it_renders_with_merged_view_data()
    {
        $builder = $this->getTestViewBuilder();
        $builder->view('ui::test-view', ['initial' => 'data']);
        $builder->viewData(['additional' => 'data']);

        $view = $builder->render();
        $data = $view->getData();

        $this->assertArrayHasKey('initial', $data);
        $this->assertArrayHasKey('additional', $data);
        $this->assertEquals('data', $data['initial']);
        $this->assertEquals('data', $data['additional']);
    }

    /** @test */
    public function it_converts_to_html()
    {
        $builder = $this->getTestViewBuilder();
        $builder->view('ui::test-view');

        $html = $builder->toHtml();

        $this->assertIsString($html);
        $this->assertStringContainsString('Test View Content', $html);
    }

    /** @test */
    public function it_can_set_query_string_identifier()
    {
        $builder = $this->getTestViewBuilder();
        
        $result = $builder->queryStringIdentifier('test-identifier');

        $this->assertSame($builder, $result);
        $this->assertEquals('test-identifier', $builder->getQueryStringIdentifier());
    }

    /** @test */
    public function it_evaluates_closure_query_string_identifier()
    {
        $builder = $this->getTestViewBuilder();
        
        $builder->queryStringIdentifier(fn() => 'dynamic-identifier');

        $this->assertEquals('dynamic-identifier', $builder->getQueryStringIdentifier());
    }

    /** @test */
    public function it_throws_exception_when_no_view_is_defined()
    {
        $builder = new TestViewBuilderNoView();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('does not have a [protected string $view] property defined');

        $builder->getView();
    }

    /** @test */
    public function it_uses_protected_view_property()
    {
        $builder = new TestViewBuilderWithProperty();

        $this->assertEquals('ui::property-view', $builder->getView());
    }

    /** @test */
    public function it_prefers_set_view_over_property()
    {
        $builder = new TestViewBuilderWithProperty();
        $builder->view('ui::override-view');

        $this->assertEquals('ui::override-view', $builder->getView());
    }

    /** @test */
    public function it_prefers_set_view_over_default_view()
    {
        $builder = $this->getTestViewBuilder();
        $builder->defaultView('ui::default-view');
        $builder->view('ui::set-view');

        $this->assertEquals('ui::set-view', $builder->getView());
    }

    /** @test */
    public function it_prefers_property_view_over_default_view()
    {
        $builder = new TestViewBuilderWithProperty();
        $builder->defaultView('ui::default-view');

        $this->assertEquals('ui::property-view', $builder->getView());
    }
}

// Test implementations
class TestViewBuilder extends ViewBuilder
{
    public function getViewData(): array
    {
        return $this->viewData;
    }
}

class TestViewBuilderWithIdentifier extends ViewBuilder
{
    protected string $viewIdentifier = 'testBuilder';
}

class TestViewBuilderNoView extends ViewBuilder
{
    // Intentionally no view property
}

class TestViewBuilderWithProperty extends ViewBuilder
{
    protected string $view = 'ui::property-view';
}
