<?php

namespace Streams\Ui\Tests\Feature;

use Livewire\Component;
use Streams\Core\Stream\Stream;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Resources\Resource;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Criteria\Criteria;
use Illuminate\Support\Facades\Route;
use Streams\Ui\Builders\Panels\Panel;
use Streams\Ui\Builders\Tables\Table;
use Streams\Ui\Builders\Actions\Action;
use Streams\Ui\Livewire\Pages\EditEntry;
use Streams\Ui\Livewire\Pages\CreateEntry;
use Streams\Ui\Livewire\Pages\ListEntries;
use Streams\Ui\Routing\RegisterPanelRoutes;
use Streams\Ui\Builders\Navigation\NavigationItem;
use Streams\Core\Criteria\Contract\AdapterInterface;
use Streams\Ui\Builders\Tables\Filters\CriteriaFilter;

class PostResource extends Resource
{
    protected static ?string $stream = 'posts';

    public static function getPages(): array
    {
        return [
            'index' => ListEntries::route('/'),
            'create' => CreateEntry::route('/create'),
            'edit' => EditEntry::route('/{entry}/edit'),
        ];
    }
}

class UiFeaturesRegistryTest extends UiTestCase
{
    public function test_generic_pages_resolve_the_current_route_before_a_cached_resource(): void
    {
        $posts = Route::get('/posts', fn () => 'posts')->defaults('uiResource', PostResource::class);
        $otherResource = new class extends Resource {};
        $other = Route::get('/other', fn () => 'other')->defaults('uiResource', $otherResource::class);

        request()->setRouteResolver(fn () => $posts);
        $this->assertSame(PostResource::class, ListEntries::getResource());

        request()->setRouteResolver(fn () => $other);
        $this->assertSame($otherResource::class, ListEntries::getResource());

        request()->setRouteResolver(fn () => $posts);
        $this->assertSame(PostResource::class, ListEntries::getResource());
    }

    /** @test */
    public function test_base_action_executes_closure_from_action_method(): void
    {
        $saved = false;

        $action = Action::make('publish')
            ->label('Publish')
            ->icon('heroicon-o-check')
            ->action(function ($entry) use (&$saved) {
                $saved = $entry === 'entry';

                return 'published';
            });

        $this->assertSame('published', $action->call(['entry' => 'entry']));
        $this->assertTrue($saved);
    }

    /** @test */
    public function test_criteria_filter_class_applies_a_criteria_closure(): void
    {
        $this->assertSame('CriteriaFilter', (new \ReflectionClass(CriteriaFilter::class))->getShortName());

        $livewire = new class extends Component
        {
            public function render()
            {
                return '';
            }
        };

        $table = Table::make($livewire, 'posts');
        $criteria = new class(\Mockery::mock(Stream::class), \Mockery::mock(AdapterInterface::class)) extends Criteria
        {
            public array $calls = [];

            public function where(string $field, ?string $operator = null, $value = null, ?string $nested = null)
            {
                $this->calls[] = [$field, $operator, $value];

                return $this;
            }
        };

        $filter = CriteriaFilter::make('status')->criteria(function (Criteria $query, $state) {
            return $query->where('status', $state);
        });

        $filter->apply($criteria, $table, 'open');

        $this->assertSame([['status', 'open', null]], $criteria->calls);
    }

    /** @test */
    public function test_navigation_item_sort_sets_sort_order(): void
    {
        $item = NavigationItem::make('Dashboard')
            ->url('/admin')
            ->icon('heroicon-o-home')
            ->sort(10);

        $this->assertSame(10, $item->getSortOrder());
    }

    /** @test */
    public function test_panel_root_redirects_to_the_first_resource(): void
    {
        UI::panel(
            Panel::make('admin')
                ->default()
                ->path('admin')
                ->middleware(['web'])
                ->resources([PostResource::class])
        );

        RegisterPanelRoutes::register();

        $this->assertSame('posts', PostResource::getSlug());

        $this->withoutExceptionHandling();

        $this->get('/admin')->assertRedirect('/admin/posts');
    }

    /** @test */
    public function test_panel_routes_use_configured_domains(): void
    {
        UI::panel(
            Panel::make('admin')
                ->default()
                ->path('admin')
                ->domains(['one.test', 'two.test'])
                ->resources([PostResource::class])
        );

        RegisterPanelRoutes::register();

        $domains = collect(Route::getRoutes()->getRoutes())
            ->filter(fn ($route) => $route->uri() === 'admin/posts')
            ->map(fn ($route) => $route->getDomain())
            ->unique()
            ->sort()
            ->values()
            ->all();

        $this->assertSame(['one.test', 'two.test'], $domains);
    }

    /** @test */
    public function test_post_resource_slug_is_posts_and_generic_pages_receive_the_resource(): void
    {
        $this->assertSame('posts', PostResource::getSlug());
        $this->assertFalse(ListEntries::hasResource());

        UI::panel(
            Panel::make('admin')
                ->default()
                ->path('admin')
                ->middleware(['web'])
                ->resources([PostResource::class])
        );

        RegisterPanelRoutes::register();

        $index = Route::getRoutes()->getByName('streams.ui.admin.posts.index');
        $create = Route::getRoutes()->getByName('streams.ui.admin.posts.create');
        $edit = Route::getRoutes()->getByName('streams.ui.admin.posts.edit');

        $this->assertNotNull($index);
        $this->assertNotNull($create);
        $this->assertNotNull($edit);
        $this->assertSame('admin/posts', $index->uri());
        $this->assertSame('admin/posts/create', $create->uri());
        $this->assertSame('admin/posts/{entry}/edit', $edit->uri());
        $this->assertSame(PostResource::class, $index->defaults['uiResource']);
        $this->assertSame(PostResource::class, $create->defaults['uiResource']);
        $this->assertSame(PostResource::class, $edit->defaults['uiResource']);
        $this->assertStringStartsWith(ListEntries::class, (string) $index->getActionName());

        request()->setRouteResolver(fn () => $index);

        $this->assertTrue(ListEntries::hasResource());
        $this->assertSame(PostResource::class, ListEntries::getResource());
        $this->assertSame('index', ListEntries::getResourcePageName());
    }

    /** @test */
    public function test_custom_panel_routes_use_panel_prefix_and_middleware(): void
    {
        UI::panel(
            Panel::make('admin')
                ->default()
                ->path('admin')
                ->domain('admin.example.com')
                ->middleware(['web'])
                ->routes(function () {
                    Route::get('/settings', fn () => 'settings')->name('settings');
                })
        );

        RegisterPanelRoutes::register();

        $route = Route::getRoutes()->getByName('streams.ui.admin.settings');

        $this->assertNotNull($route);
        $this->assertSame('admin/settings', $route->uri());
        $this->assertSame('admin.example.com', $route->getDomain());
        $this->assertContains('panel:admin', $route->gatherMiddleware());
        $this->assertContains('web', $route->gatherMiddleware());
    }
}
