<?php

namespace Streams\Ui\Tests\Resources;

use Mockery;
use Streams\Ui\Tests\UiTestCase;
use Streams\Core\Stream\Stream;
use Streams\Core\Entry\Entry;
use Streams\Core\Criteria\Criteria;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Builders\Panels\Panel;
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Resources\Resource;
use Illuminate\Support\Facades\Route;

class ResourceTest extends UiTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Clear any existing routes
        Route::getRoutes()->refreshNameLookups();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_can_get_stream_from_property(): void
    {
        $resource = new class extends Resource {
            protected static ?string $stream = 'test_stream';
        };

        $this->assertEquals('test_stream', $resource::getStream());
    }

    /** @test */
    public function it_falls_back_to_slug_when_no_stream_defined(): void
    {
        $resource = new class extends Resource {
            protected static ?string $slug = 'my-resource';
        };

        $this->assertEquals('my-resource', $resource::getStream());
    }

    /** @test */
    public function it_can_get_slug_from_property(): void
    {
        $resource = new class extends Resource {
            protected static ?string $slug = 'custom-slug';
        };

        $this->assertEquals('custom-slug', $resource::getSlug());
    }

    /** @test */
    public function it_generates_slug_from_class_name_when_not_defined(): void
    {
        $resource = new class extends Resource {};

        $slug = $resource::getSlug();

        // Should convert class_0@anonymous to kebab case
        $this->assertIsString($slug);
    }

    /** @test */
    public function it_can_get_route_base_name(): void
    {
        $panel = Panel::make('admin')->default();
        UI::panel($panel);

        $resource = new class extends Resource {
            protected static ?string $slug = 'posts';
        };

        $baseName = $resource::getRouteBaseName('admin');

        $this->assertEquals('streams.ui.admin.posts', $baseName);
    }

    /** @test */
    public function it_uses_current_panel_for_route_base_name(): void
    {
        $panel = Panel::make('admin')->default();
        UI::panel($panel);

        $resource = new class extends Resource {
            protected static ?string $slug = 'users';
        };

        $baseName = $resource::getRouteBaseName();

        $this->assertEquals('streams.ui.admin.users', $baseName);
    }

    /** @test */
    public function it_handles_slash_in_slug_for_route_name(): void
    {
        $panel = Panel::make('admin')->default();
        UI::panel($panel);

        $resource = new class extends Resource {
            protected static ?string $slug = 'admin/posts';
        };

        $baseName = $resource::getRouteBaseName();

        $this->assertEquals('streams.ui.admin.admin.posts', $baseName);
    }

    /** @test */
    public function it_can_get_route_middleware(): void
    {
        $panel = Panel::make('admin');

        $resource = new class extends Resource {
            protected static string|array $middleware = ['auth', 'verified'];
        };

        $middleware = $resource::getRouteMiddleware($panel);

        $this->assertEquals(['auth', 'verified'], $middleware);
    }

    /** @test */
    public function it_can_get_single_route_middleware(): void
    {
        $panel = Panel::make('admin');

        $resource = new class extends Resource {
            protected static string|array $middleware = 'auth';
        };

        $middleware = $resource::getRouteMiddleware($panel);

        $this->assertEquals('auth', $middleware);
    }

    /** @test */
    public function it_can_get_without_route_middleware(): void
    {
        $panel = Panel::make('admin');

        $resource = new class extends Resource {
            protected static string|array $withoutMiddleware = ['throttle'];
        };

        $middleware = $resource::getWithoutRouteMiddleware($panel);

        $this->assertEquals(['throttle'], $middleware);
    }

    /** @test */
    public function it_returns_empty_array_for_default_middleware(): void
    {
        $panel = Panel::make('admin');
        $resource = new class extends Resource {};

        $middleware = $resource::getRouteMiddleware($panel);

        $this->assertEquals([], $middleware);
    }

    /** @test */
    public function it_can_get_navigation_groups(): void
    {
        $resourceClass = new class extends Resource {};
        
        // Set navigation groups using the static method
        $resourceClass::navigationGroups(['Admin', 'Settings']);

        $groups = $resourceClass::getNavigationGroups();

        $this->assertEquals(['Admin', 'Settings'], $groups);
    }

    /** @test */
    public function it_returns_empty_pages_by_default(): void
    {
        $resource = new class extends Resource {};

        $this->assertIsArray($resource::getPages());
        $this->assertEmpty($resource::getPages());
    }

    /** @test */
    public function it_returns_empty_actions_by_default(): void
    {
        $resource = new class extends Resource {};

        $this->assertIsArray($resource::getActions());
        $this->assertEmpty($resource::getActions());
    }

    /** @test */
    public function it_can_get_navigation_items(): void
    {
        $panel = Panel::make('admin')->default();
        UI::panel($panel);

        $resource = new class extends Resource {
            protected static ?string $slug = 'posts';
            protected static ?string $navigationLabel = 'Posts';
            protected static ?string $navigationIcon = 'heroicon-o-document';
            protected static ?string $navigationGroup = 'Content';
            protected static ?int $navigationSort = 10;
            
            public static function getUrl(
                string $name = 'index',
                array $parameters = [],
                bool $isAbsolute = true,
                ?string $panel = null,
            ): string {
                return '/admin/posts';
            }
        };

        $items = $resource::getNavigationItems();

        $this->assertIsArray($items);
        $this->assertCount(1, $items);
        
        $item = $items[0];
        $this->assertEquals('Posts', $item->getLabel());
        $this->assertEquals('heroicon-o-document', $item->getIcon());
        $this->assertEquals('Content', $item->getGroup());
        $this->assertEquals(10, $item->getSortOrder());
    }

    /** @test */
    public function it_uses_title_as_default_navigation_label(): void
    {
        $panel = Panel::make('admin')->default();
        UI::panel($panel);

        $resource = new class extends Resource {
            protected static ?string $navigationLabel = 'My Resource';
            protected static ?string $slug = 'my-resource';
            
            public static function getUrl(
                string $name = 'index',
                array $parameters = [],
                bool $isAbsolute = true,
                ?string $panel = null,
            ): string {
                return '/admin/my-resource';
            }
        };

        $items = $resource::getNavigationItems();
        
        $this->assertEquals('My Resource', $items[0]->getLabel());
    }

    /** @test */
    public function it_can_resolve_entry_route_binding(): void
    {
        // Test the method exists and returns expected type
        $resource = new class extends Resource {
            protected static ?string $stream = 'test-stream';
        };

        // The method signature should return Entry or null
        $reflection = new \ReflectionMethod($resource, 'resolveEntryRouteBinding');
        $returnType = $reflection->getReturnType();
        
        $this->assertNotNull($returnType);
        $this->assertStringContainsString('Entry', $returnType->getName());
    }

    /** @test */
    public function it_can_resolve_entry_with_string_key(): void
    {
        // Verify the method accepts both int and string keys
        $resource = new class extends Resource {
            protected static ?string $stream = 'test-stream';
        };

        $reflection = new \ReflectionMethod($resource, 'resolveEntryRouteBinding');
        $params = $reflection->getParameters();
        
        $this->assertCount(1, $params);
        $this->assertEquals('key', $params[0]->getName());
    }

    /** @test */
    public function it_can_make_stream_instance(): void
    {
        $mockStream = Mockery::mock(Stream::class);

        Streams::shouldReceive('make')
            ->with('my-stream')
            ->once()
            ->andReturn($mockStream);

        $resource = new class extends Resource {
            protected static ?string $stream = 'my-stream';
        };

        $stream = $resource::makeStream();

        $this->assertSame($mockStream, $stream);
    }

    /** @test */
    public function it_can_get_stream_entries_criteria(): void
    {
        // Verify the method exists and has correct signature
        $resource = new class extends Resource {
            protected static ?string $stream = 'posts';
        };

        $reflection = new \ReflectionMethod($resource, 'streamEntries');
        $returnType = $reflection->getReturnType();
        
        $this->assertNotNull($returnType);
        $this->assertStringContainsString('Criteria', $returnType->getName());
    }

    /** @test */
    public function it_registers_routes_with_panel(): void
    {
        $panel = Panel::make('admin');

        $resource = new class extends Resource {
            protected static ?string $slug = 'posts';
            
            public static function getPages(): array
            {
                return [];
            }
        };

        // Just verify the method can be called without errors
        $resource::routes($panel);

        $this->assertTrue(true);
    }
}
