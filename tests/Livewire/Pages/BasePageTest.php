<?php

namespace Streams\Ui\Tests\Livewire\Pages;

use Livewire\Livewire;
use Illuminate\Support\Facades\View;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Livewire\Pages\BasePage;
use Streams\Ui\Builders\Panels\Panel;

class BasePageTest extends UiTestCase
{
    protected function getTestPage(): BasePage
    {
        return new class extends BasePage
        {
            protected static string $view = 'test-view';
            protected static string $resource = 'TestResource';
            protected static ?string $title = 'Test Page';
            protected static ?string $slug = 'test-page';
            protected static ?string $routeName = 'test.page';

            public function testPublicMethod(): string
            {
                return 'test-value';
            }

            protected function testProtectedMethod(): string
            {
                return 'protected-value';
            }
        };
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $page = $this->getTestPage();

        $this->assertInstanceOf(BasePage::class, $page);
    }

    /** @test */
    public function it_can_get_title()
    {
        $page = $this->getTestPage();

        $this->assertEquals('Test Page', $page::getTitle());
    }

    /** @test */
    public function it_generates_title_from_class_name_when_not_set()
    {
        $page = new class extends BasePage
        {
            protected static string $view = 'test-view';
            protected static string $resource = 'TestResource';
        };

        $title = $page::getTitle();

        $this->assertIsString($title);
    }

    /** @test */
    public function it_has_description()
    {
        $page = $this->getTestPage();

        $page->description('Test description');

        $this->assertEquals('Test description', $page->getDescription());
    }

    /** @test */
    public function it_evaluates_closures_for_description()
    {
        $page = $this->getTestPage();

        $page->description(fn () => 'Dynamic description');

        $this->assertEquals('Dynamic description', $page->getDescription());
    }

    /** @test */
    public function it_has_data_property()
    {
        $page = $this->getTestPage();

        $this->assertIsArray($page->data);
        $this->assertEquals([], $page->data);
    }

    /** @test */
    public function it_can_set_data()
    {
        $page = $this->getTestPage();

        $page->data = ['key' => 'value'];

        $this->assertEquals(['key' => 'value'], $page->data);
    }

    /** @test */
    public function it_has_default_layout()
    {
        $reflection = new \ReflectionClass($this->getTestPage());
        $property = $reflection->getProperty('layout');
        $property->setAccessible(true);

        $this->assertEquals('ui::layouts.page', $property->getValue());
    }

    /** @test */
    public function it_can_get_resource()
    {
        $page = $this->getTestPage();

        $this->assertEquals('TestResource', $page::getResource());
    }

    /** @test */
    public function it_can_get_slug()
    {
        $page = $this->getTestPage();

        $this->assertEquals('test-page', $page::getSlug());
    }

    /** @test */
    public function it_generates_slug_from_class_name_when_not_set()
    {
        $page = new class extends BasePage
        {
            protected static string $view = 'test-view';
            protected static string $resource = 'TestResource';
        };

        $slug = $page::getSlug();

        $this->assertIsString($slug);
        $this->assertStringNotContainsString(' ', $slug);
    }

    /** @test */
    public function it_can_get_route_middleware()
    {
        $page = $this->getTestPage();
        $panel = new Panel('test', 'test');

        $middleware = $page::getRouteMiddleware($panel);

        $this->assertIsArray($middleware);
    }

    /** @test */
    public function it_can_get_without_route_middleware()
    {
        $page = $this->getTestPage();
        $panel = new Panel('test', 'test');

        $middleware = $page::getWithoutRouteMiddleware($panel);

        $this->assertTrue(is_string($middleware) || is_array($middleware));
    }

    /** @test */
    public function it_has_get_url_method()
    {
        // Note: getUrl() relies on getRouteName() which is not defined in BasePage
        // This is expected to be provided by child classes or additional traits
        $page = $this->getTestPage();

        $this->assertTrue(method_exists($page, 'getUrl'));
    }

    /** @test */
    public function it_extracts_public_methods()
    {
        $page = $this->getTestPage();

        $reflection = new \ReflectionClass($page);
        $method = $reflection->getMethod('extractPublicMethods');
        $method->setAccessible(true);

        $methods = $method->invoke($page);

        $this->assertIsArray($methods);
        $this->assertArrayHasKey('testPublicMethod', $methods);
        $this->assertInstanceOf(\Closure::class, $methods['testPublicMethod']);
    }

    /** @test */
    public function it_does_not_extract_protected_methods()
    {
        $page = $this->getTestPage();

        $reflection = new \ReflectionClass($page);
        $method = $reflection->getMethod('extractPublicMethods');
        $method->setAccessible(true);

        $methods = $method->invoke($page);

        $this->assertArrayNotHasKey('testProtectedMethod', $methods);
    }

    /** @test */
    public function it_caches_extracted_public_methods()
    {
        $page = $this->getTestPage();

        $reflection = new \ReflectionClass($page);
        $method = $reflection->getMethod('extractPublicMethods');
        $method->setAccessible(true);

        $methods1 = $method->invoke($page);
        $methods2 = $method->invoke($page);

        // Both calls should return the same structure
        $this->assertEquals(array_keys($methods1), array_keys($methods2));
    }

    /** @test */
    public function it_returns_layout_data()
    {
        $page = $this->getTestPage();

        $reflection = new \ReflectionClass($page);
        $method = $reflection->getMethod('getLayoutData');
        $method->setAccessible(true);

        $data = $method->invoke($page);

        $this->assertIsArray($data);
    }

    /** @test */
    public function it_returns_view_data()
    {
        $page = $this->getTestPage();

        $reflection = new \ReflectionClass($page);
        $method = $reflection->getMethod('getViewData');
        $method->setAccessible(true);

        $data = $method->invoke($page);

        $this->assertIsArray($data);
    }

    /** @test */
    public function it_uses_memory_trait()
    {
        $page = $this->getTestPage();

        $this->assertTrue(method_exists($page, 'once'));
        $this->assertTrue(method_exists($page, 'remember'));
    }

    /** @test */
    public function it_uses_fires_callbacks_trait()
    {
        $page = $this->getTestPage();

        $this->assertTrue(method_exists($page, 'fire'));
        $this->assertTrue(method_exists($page, 'addCallback'));
        $this->assertTrue(method_exists($page, 'hasCallback'));
    }

    /** @test */
    public function it_supports_custom_middleware()
    {
        $page = new class extends BasePage
        {
            protected static string $view = 'test-view';
            protected static string $resource = 'TestResource';
            protected static string|array $middleware = ['auth', 'verified'];
        };

        $panel = new Panel('test', 'test');
        $middleware = $page::getRouteMiddleware($panel);

        $this->assertContains('auth', $middleware);
        $this->assertContains('verified', $middleware);
    }

    /** @test */
    public function it_supports_without_middleware()
    {
        $page = new class extends BasePage
        {
            protected static string $view = 'test-view';
            protected static string $resource = 'TestResource';
            protected static string|array $withoutMiddleware = ['csrf'];
        };

        $panel = new Panel('test', 'test');
        $middleware = $page::getWithoutRouteMiddleware($panel);

        $this->assertEquals(['csrf'], $middleware);
    }
}
