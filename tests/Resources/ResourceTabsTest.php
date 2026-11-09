<?php

namespace Streams\Ui\Tests\Resources;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Resources\Resource;
use Streams\Ui\Support\Facades\UI;
use Illuminate\Support\Facades\Route;
use Streams\Ui\Builders\Panels\Panel;
use Streams\Ui\Builders\Breadcrumbs\Breadcrumbs;

class ResourceTabsTest extends UiTestCase
{
    protected function resource(): string
    {
        UI::panel(Panel::make('admin')->default());

        $class = new class extends Resource
        {
            protected static ?string $slug = 'things';

            protected static array $tabs = ['index' => 'All', 'edit' => 'Edit'];
        };

        $base = $class::getRouteBaseName();

        Route::get('/things', fn () => 'ok')->name("$base.index");
        Route::get('/things/edit', fn () => 'ok')->name("$base.edit");

        Route::getRoutes()->refreshNameLookups();

        return get_class($class);
    }

    /** @test */
    public function it_exposes_declarative_tabs(): void
    {
        $this->assertSame(['index' => 'All', 'edit' => 'Edit'], $this->resource()::tabs());
    }

    /** @test */
    public function it_derives_the_active_tab_from_the_route(): void
    {
        $resource = $this->resource();

        $this->get('/things/edit');

        $active = collect($resource::getTabs())->where('active', true)->pluck('name')->all();

        $this->assertSame(['edit'], $active);
    }

    /** @test */
    public function it_builds_a_breadcrumb_chain(): void
    {
        $this->assertInstanceOf(Breadcrumbs::class, $this->resource()::getBreadcrumbs('edit'));
    }
}
