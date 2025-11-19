<?php

namespace Streams\Ui\Tests\Livewire\Pages;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Livewire\Pages\Page;
use Streams\Ui\Builders\Panels\Panel;
use Streams\Ui\Support\Facades\UI;

class PageTest extends UiTestCase
{
    protected function getTestPage(): Page
    {
        return new class extends Page
        {
            protected static string $view = 'test-view';
            protected static string $resource = 'TestResource';
            protected static ?string $title = 'Test Page';
            protected static ?string $slug = 'test-page';
            protected static ?string $navigationLabel = 'Test Nav';
            protected static ?string $navigationIcon = 'test-icon';

            public function testPublicMethod(): string
            {
                return 'test-value';
            }
        };
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $page = $this->getTestPage();

        $this->assertInstanceOf(Page::class, $page);
    }

    /** @test */
    public function it_extends_base_page()
    {
        $page = $this->getTestPage();

        $this->assertInstanceOf(\Livewire\Component::class, $page);
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
        $page = new class extends Page
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
    public function it_has_state_path_property()
    {
        $reflection = new \ReflectionClass($this->getTestPage());
        $property = $reflection->getProperty('statePath');
        $property->setAccessible(true);

        $this->assertEquals('data', $property->getValue($this->getTestPage()));
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
        $page = new class extends Page
        {
            protected static string $view = 'test-view';
            protected static string $resource = 'TestResource';
        };

        $slug = $page::getSlug();

        $this->assertIsString($slug);
        $this->assertStringNotContainsString(' ', $slug);
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
    }

    /** @test */
    public function it_uses_has_actions_trait()
    {
        $page = $this->getTestPage();

        $this->assertTrue(method_exists($page, 'actions'));
        $this->assertTrue(method_exists($page, 'getActions'));
    }

    /** @test */
    public function it_uses_has_html_attributes_trait()
    {
        $page = $this->getTestPage();

        $this->assertTrue(method_exists($page, 'htmlAttributes'));
        $this->assertTrue(method_exists($page, 'getHtmlAttributes'));
    }

    /** @test */
    public function it_uses_interacts_with_actions_trait()
    {
        $page = $this->getTestPage();

        $this->assertTrue(method_exists($page, 'mountAction'));
        $this->assertTrue(method_exists($page, 'callMountedAction'));
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
    public function it_caches_extracted_public_methods()
    {
        $page = $this->getTestPage();

        $reflection = new \ReflectionClass($page);
        $method = $reflection->getMethod('extractPublicMethods');
        $method->setAccessible(true);

        $methods1 = $method->invoke($page);
        $methods2 = $method->invoke($page);

        $this->assertEquals(array_keys($methods1), array_keys($methods2));
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
    public function it_should_register_navigation_by_default()
    {
        $page = $this->getTestPage();

        $reflection = new \ReflectionClass($page);
        $method = $reflection->getMethod('shouldRegisterNavigation');
        $method->setAccessible(true);

        $this->assertTrue($method->invoke($page));
    }

    /** @test */
    public function it_can_get_navigation_label()
    {
        $page = $this->getTestPage();

        $reflection = new \ReflectionClass($page);
        $method = $reflection->getMethod('getNavigationLabel');
        $method->setAccessible(true);

        $this->assertEquals('Test Nav', $method->invoke($page));
    }

    /** @test */
    public function it_falls_back_to_title_for_navigation_label()
    {
        $page = new class extends Page
        {
            protected static string $view = 'test-view';
            protected static string $resource = 'TestResource';
            protected static ?string $title = 'Fallback Title';
        };

        $reflection = new \ReflectionClass($page);
        $method = $reflection->getMethod('getNavigationLabel');
        $method->setAccessible(true);

        $this->assertEquals('Fallback Title', $method->invoke($page));
    }

    /** @test */
    public function it_can_get_navigation_icon()
    {
        $page = $this->getTestPage();

        $reflection = new \ReflectionClass($page);
        $method = $reflection->getMethod('getNavigationIcon');
        $method->setAccessible(true);

        $this->assertEquals('test-icon', $method->invoke($page));
    }

    /** @test */
    public function it_falls_back_to_navigation_icon_for_active_icon()
    {
        $page = $this->getTestPage();

        $reflection = new \ReflectionClass($page);
        $method = $reflection->getMethod('getActiveNavigationIcon');
        $method->setAccessible(true);

        $this->assertEquals('test-icon', $method->invoke($page));
    }

    /** @test */
    public function it_returns_null_for_navigation_badge()
    {
        $page = $this->getTestPage();

        $reflection = new \ReflectionClass($page);
        $method = $reflection->getMethod('getNavigationBadge');
        $method->setAccessible(true);

        $this->assertNull($method->invoke($page));
    }

    /** @test */
    public function it_returns_null_for_navigation_badge_color()
    {
        $page = $this->getTestPage();

        $reflection = new \ReflectionClass($page);
        $method = $reflection->getMethod('getNavigationBadgeColor');
        $method->setAccessible(true);

        $this->assertNull($method->invoke($page));
    }

    /** @test */
    public function it_can_get_navigation_group()
    {
        $page = new class extends Page
        {
            protected static string $view = 'test-view';
            protected static string $resource = 'TestResource';
            protected static ?string $navigationGroup = 'Settings';
        };

        $reflection = new \ReflectionClass($page);
        $method = $reflection->getMethod('getNavigationGroup');
        $method->setAccessible(true);

        $this->assertEquals('Settings', $method->invoke($page));
    }

    /** @test */
    public function it_can_get_navigation_sort()
    {
        $page = new class extends Page
        {
            protected static string $view = 'test-view';
            protected static string $resource = 'TestResource';
            protected static ?int $navigationSort = 10;
        };

        $reflection = new \ReflectionClass($page);
        $method = $reflection->getMethod('getNavigationSort');
        $method->setAccessible(true);

        $this->assertEquals(10, $method->invoke($page));
    }

    /** @test */
    public function it_supports_custom_middleware()
    {
        $page = new class extends Page
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
        $page = new class extends Page
        {
            protected static string $view = 'test-view';
            protected static string $resource = 'TestResource';
            protected static string|array $withoutMiddleware = ['csrf'];
        };

        $panel = new Panel('test', 'test');
        $middleware = $page::getWithoutRouteMiddleware($panel);

        $this->assertEquals(['csrf'], $middleware);
    }

    /** @test */
    public function it_has_get_navigation_items_method()
    {
        $page = $this->getTestPage();

        $this->assertTrue(method_exists($page, 'getNavigationItems'));
    }

    /** @test */
    public function it_has_navigation_groups_trait()
    {
        $page = $this->getTestPage();

        $this->assertTrue(method_exists($page, 'navigationGroups'));
        $this->assertTrue(method_exists($page, 'getNavigationGroups'));
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
    public function it_can_render()
    {
        $page = $this->getTestPage();

        $this->app['view']->addNamespace('test', __DIR__);
        $this->app['view']->addLocation(__DIR__);
        
        // Create a simple test view
        file_put_contents(__DIR__ . '/test-view.blade.php', '<div>Test</div>');

        $result = $page->render();

        $this->assertInstanceOf(\Illuminate\Contracts\View\View::class, $result);
        
        // Cleanup
        @unlink(__DIR__ . '/test-view.blade.php');
    }
}
