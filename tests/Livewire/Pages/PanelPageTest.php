<?php

namespace Streams\Ui\Tests\Livewire\Pages;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Livewire\Pages\Page;
use Streams\Ui\Livewire\Pages\PanelPage;

class PanelPageTest extends UiTestCase
{
    protected function getTestPanelPage(): PanelPage
    {
        return new class extends PanelPage
        {
            protected static string $view = 'test-view';
            protected static string $resource = 'TestResource';
            protected static ?string $title = 'Test Panel Page';
        };
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $page = $this->getTestPanelPage();

        $this->assertInstanceOf(PanelPage::class, $page);
    }

    /** @test */
    public function it_extends_page()
    {
        $page = $this->getTestPanelPage();

        $this->assertInstanceOf(Page::class, $page);
    }

    /** @test */
    public function it_extends_livewire_component()
    {
        $page = $this->getTestPanelPage();

        $this->assertInstanceOf(\Livewire\Component::class, $page);
    }

    /** @test */
    public function it_has_panel_layout()
    {
        $reflection = new \ReflectionClass($this->getTestPanelPage());
        $property = $reflection->getProperty('layout');
        $property->setAccessible(true);

        $this->assertEquals('ui::layouts.panel', $property->getValue());
    }

    /** @test */
    public function it_inherits_page_functionality()
    {
        $page = $this->getTestPanelPage();

        $this->assertEquals('Test Panel Page', $page::getTitle());
    }

    /** @test */
    public function it_inherits_resource_functionality()
    {
        $page = $this->getTestPanelPage();

        $this->assertEquals('TestResource', $page::getResource());
    }

    /** @test */
    public function it_inherits_slug_functionality()
    {
        $page = $this->getTestPanelPage();

        $slug = $page::getSlug();

        $this->assertIsString($slug);
    }

    /** @test */
    public function it_inherits_navigation_functionality()
    {
        $page = $this->getTestPanelPage();

        $this->assertTrue(method_exists($page, 'getNavigationItems'));
        $this->assertTrue(method_exists($page, 'registerNavigationItems'));
    }

    /** @test */
    public function it_inherits_actions_functionality()
    {
        $page = $this->getTestPanelPage();

        $this->assertTrue(method_exists($page, 'actions'));
        $this->assertTrue(method_exists($page, 'getActions'));
    }

    /** @test */
    public function it_inherits_html_attributes_functionality()
    {
        $page = $this->getTestPanelPage();

        $this->assertTrue(method_exists($page, 'htmlAttributes'));
        $this->assertTrue(method_exists($page, 'getHtmlAttributes'));
    }

    /** @test */
    public function it_inherits_description_functionality()
    {
        $page = $this->getTestPanelPage();

        $page->description('Panel description');

        $this->assertEquals('Panel description', $page->getDescription());
    }

    /** @test */
    public function it_inherits_data_property()
    {
        $page = $this->getTestPanelPage();

        $this->assertIsArray($page->data);
        $this->assertEquals([], $page->data);
    }

    /** @test */
    public function it_inherits_state_path_property()
    {
        $reflection = new \ReflectionClass($this->getTestPanelPage());
        $property = $reflection->getProperty('statePath');
        $property->setAccessible(true);

        $this->assertEquals('data', $property->getValue($this->getTestPanelPage()));
    }

    /** @test */
    public function it_inherits_memory_trait()
    {
        $page = $this->getTestPanelPage();

        $this->assertTrue(method_exists($page, 'once'));
        $this->assertTrue(method_exists($page, 'remember'));
    }

    /** @test */
    public function it_inherits_fires_callbacks_trait()
    {
        $page = $this->getTestPanelPage();

        $this->assertTrue(method_exists($page, 'fire'));
        $this->assertTrue(method_exists($page, 'addCallback'));
    }

    /** @test */
    public function it_can_be_extended()
    {
        $customPage = new class extends PanelPage
        {
            protected static string $view = 'custom-view';
            protected static string $resource = 'CustomResource';
            protected static ?string $title = 'Custom Panel Page';

            public function customMethod(): string
            {
                return 'custom';
            }
        };

        $this->assertEquals('Custom Panel Page', $customPage::getTitle());
        $this->assertEquals('custom', $customPage->customMethod());
    }

    /** @test */
    public function it_can_override_layout()
    {
        $customPage = new class extends PanelPage
        {
            protected static string $view = 'test-view';
            protected static string $resource = 'TestResource';
            protected static string $layout = 'custom::layout';
        };

        $reflection = new \ReflectionClass($customPage);
        $property = $reflection->getProperty('layout');
        $property->setAccessible(true);

        $this->assertEquals('custom::layout', $property->getValue());
    }

    /** @test */
    public function it_uses_evaluates_closures_trait()
    {
        $page = $this->getTestPanelPage();

        $this->assertTrue(method_exists($page, 'evaluate'));
    }

    /** @test */
    public function it_has_routes_trait()
    {
        $page = $this->getTestPanelPage();

        $this->assertTrue(method_exists($page, 'routes'));
        $this->assertTrue(method_exists($page, 'route'));
        $this->assertTrue(method_exists($page, 'getSlug'));
    }

    /** @test */
    public function it_has_navigation_groups_trait()
    {
        $page = $this->getTestPanelPage();

        $this->assertTrue(method_exists($page, 'navigationGroups'));
        $this->assertTrue(method_exists($page, 'getNavigationGroups'));
    }

    /** @test */
    public function it_can_render()
    {
        $page = $this->getTestPanelPage();

        $this->app['view']->addNamespace('test', __DIR__);
        $this->app['view']->addLocation(__DIR__);
        
        // Create a simple test view
        file_put_contents(__DIR__ . '/test-view.blade.php', '<div>Panel Test</div>');

        $result = $page->render();

        $this->assertInstanceOf(\Illuminate\Contracts\View\View::class, $result);
        
        // Cleanup
        @unlink(__DIR__ . '/test-view.blade.php');
    }
}
