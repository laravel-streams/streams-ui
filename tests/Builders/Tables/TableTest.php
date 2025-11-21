<?php

namespace Streams\Ui\Tests\Builders\Tables;

use Livewire\Component;
use Streams\Ui\Builders\Builder;
use Streams\Ui\Tests\UiTestCase;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Tables\Table;
use Streams\Ui\Builders\Actions\Action;
use Illuminate\Contracts\Support\Htmlable;
use Streams\Ui\Builders\Tables\Columns\TextColumn;

class TableTest extends UiTestCase
{
    protected function getTestLivewireComponent(): Component
    {
        return new class extends Component
        {
            use \InteractsWithTablesStreams\Ui\Livewire\Tables\InteractsWithTable;
        };
    }

    protected function getTestTable(): Table
    {
        return new Table($this->getTestLivewireComponent());
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $table = $this->getTestTable();

        $this->assertInstanceOf(Builder::class, $table);
        $this->assertInstanceOf(ViewBuilder::class, $table);
        $this->assertInstanceOf(Table::class, $table);
        $this->assertInstanceOf(Htmlable::class, $table);
    }

    /** @test */
    public function it_can_be_made_with_static_method()
    {
        $livewire = $this->getTestLivewireComponent();
        $table = Table::make($livewire);

        $this->assertInstanceOf(Table::class, $table);
        $this->assertSame($livewire, $table->getLivewire());
    }

    /** @test */
    public function it_requires_livewire_component_on_construction()
    {
        $livewire = $this->getTestLivewireComponent();
        $table = new Table($livewire);

        $this->assertSame($livewire, $table->getLivewire());
    }

    /** @test */
    public function it_has_default_view()
    {
        $table = $this->getTestTable();

        $this->assertEquals('ui::builders.table', $table->getView());
    }

    /** @test */
    public function it_has_view_identifier()
    {
        $table = $this->getTestTable();

        $view = $table->render();
        $data = $view->getData();

        $this->assertArrayHasKey('table', $data);
        $this->assertSame($table, $data['table']);
    }

    /** @test */
    public function it_has_query_string_identifier()
    {
        $table = $this->getTestTable();

        $this->assertEquals('table', $table->getQueryStringIdentifier());
    }

    /** @test */
    public function it_can_get_entries()
    {
        $table = $this->getTestTable();

        $entries = $table->getEntries();

        $this->assertInstanceOf(Collection::class, $entries);
        $this->assertCount(2, $entries);
    }

    /** @test */
    public function it_can_set_and_get_columns()
    {
        $table = $this->getTestTable();
        $column1 = TextColumn::make('name');
        $column2 = TextColumn::make('email');

        $result = $table->columns([$column1, $column2]);

        $this->assertSame($table, $result);
        $this->assertCount(2, $table->getColumns());
    }

    /** @test */
    public function it_can_append_columns()
    {
        $table = $this->getTestTable();
        $column1 = TextColumn::make('name');
        $column2 = TextColumn::make('email');

        $table->columns([$column1]);
        $table->columns([$column2]);

        $this->assertCount(2, $table->getColumns());
    }

    /** @test */
    public function it_can_get_column_by_name()
    {
        $table = $this->getTestTable();
        $column = TextColumn::make('name');

        $table->columns([$column]);

        $retrieved = $table->getColumn('name');

        $this->assertSame($column, $retrieved);
    }

    /** @test */
    public function it_returns_null_for_non_existent_column()
    {
        $table = $this->getTestTable();

        $this->assertNull($table->getColumn('non-existent'));
    }

    /** @test */
    public function it_can_get_visible_columns()
    {
        $table = $this->getTestTable();
        $visible = TextColumn::make('visible');
        $hidden = TextColumn::make('hidden')->hidden();

        $table->columns([$visible, $hidden]);

        $visibleColumns = $table->getVisibleColumns();

        $this->assertCount(1, $visibleColumns);
        $this->assertSame($visible, reset($visibleColumns));
    }

    /** @test */
    public function it_can_get_searchable_columns()
    {
        $table = $this->getTestTable();
        $searchable = TextColumn::make('searchable')->searchable();
        $notSearchable = TextColumn::make('not-searchable');

        $table->columns([$searchable, $notSearchable]);

        $searchableColumns = $table->getSearchableColumns();

        $this->assertCount(1, $searchableColumns);
        $this->assertSame($searchable, reset($searchableColumns));
    }

    /** @test */
    public function it_can_set_and_get_actions()
    {
        $table = $this->getTestTable();
        $action = Action::make('test-action');

        $result = $table->actions([$action]);

        $this->assertSame($table, $result);
        $this->assertCount(1, $table->getActions());
    }

    /** @test */
    public function it_can_push_actions()
    {
        $table = $this->getTestTable();
        $action1 = Action::make('action-1');
        $action2 = Action::make('action-2');

        $table->pushActions([$action1]);
        $table->pushActions([$action2]);

        $this->assertCount(2, $table->getActions());
    }

    /** @test */
    public function it_can_set_and_get_heading()
    {
        $table = $this->getTestTable();

        $result = $table->heading('Test Table');

        $this->assertSame($table, $result);
        $this->assertEquals('Test Table', $table->getHeading());
    }

    /** @test */
    public function it_evaluates_closure_heading()
    {
        $table = $this->getTestTable();

        $table->heading(fn () => 'Dynamic Heading');

        $this->assertEquals('Dynamic Heading', $table->getHeading());
    }

    /** @test */
    public function it_can_set_and_get_description()
    {
        $table = $this->getTestTable();

        $result = $table->description('Table description');

        $this->assertSame($table, $result);
        $this->assertEquals('Table description', $table->getDescription());
    }

    /** @test */
    public function it_evaluates_closure_description()
    {
        $table = $this->getTestTable();

        $table->description(fn () => 'Dynamic Description');

        $this->assertEquals('Dynamic Description', $table->getDescription());
    }

    /** @test */
    public function it_can_configure_pagination()
    {
        $table = $this->getTestTable();

        $result = $table->paginated(true);

        $this->assertSame($table, $result);
        $this->assertTrue($table->isPaginated());
    }

    /** @test */
    public function it_can_disable_pagination()
    {
        $table = $this->getTestTable();

        $table->paginated(false);

        $this->assertFalse($table->isPaginated());
    }

    /** @test */
    public function it_can_set_per_page()
    {
        $table = $this->getTestTable();

        $result = $table->perPage(50);

        $this->assertSame($table, $result);
        $this->assertEquals(50, $table->getPerPage());
    }

    /** @test */
    public function it_has_default_per_page()
    {
        $table = $this->getTestTable();

        $this->assertEquals(25, $table->getPerPage());
    }

    /** @test */
    public function it_can_set_pagination_options()
    {
        $table = $this->getTestTable();
        $options = [10, 25, 50];

        $result = $table->paginationOptions($options);

        $this->assertSame($table, $result);
        $this->assertEquals($options, $table->getPaginationOptions());
    }

    /** @test */
    public function it_has_default_pagination_options()
    {
        $table = $this->getTestTable();

        $options = $table->getPaginationOptions();

        $this->assertEquals([5, 10, 25, 50, 100, 'all'], $options);
    }

    /** @test */
    public function it_can_configure_pagination_with_options()
    {
        $table = $this->getTestTable();

        $table->paginated([10, 20, 30]);

        $this->assertTrue($table->isPaginated());
        $this->assertEquals([10, 20, 30], $table->getPaginationOptions());
    }

    /** @test */
    public function it_can_set_default_sort()
    {
        $table = $this->getTestTable();

        $result = $table->defaultSort('name', 'asc');

        $this->assertSame($table, $result);
        $this->assertEquals('name', $table->getDefaultSortColumn());
        $this->assertEquals('asc', $table->getDefaultSortDirection());
    }

    /** @test */
    public function it_can_set_default_sort_direction_to_desc()
    {
        $table = $this->getTestTable();

        $table->defaultSort('name', 'desc');

        $this->assertEquals('desc', $table->getDefaultSortDirection());
    }

    /** @test */
    public function it_normalizes_sort_direction_to_lowercase()
    {
        $table = $this->getTestTable();

        $table->defaultSort('name', 'DESC');

        $this->assertEquals('desc', $table->getDefaultSortDirection());
    }

    /** @test */
    public function it_can_set_default_sort_with_closure()
    {
        $table = $this->getTestTable();
        $closure = fn () => 'custom sort';

        $table->defaultSort($closure, 'asc');

        $this->assertSame($closure, $table->getDefaultSortQuery());
    }

    /** @test */
    public function it_evaluates_closure_sort_direction()
    {
        $table = $this->getTestTable();

        $table->defaultSort('name', fn () => 'desc');

        $this->assertEquals('desc', $table->getDefaultSortDirection());
    }

    /** @test */
    public function it_can_get_sortable_column()
    {
        $table = $this->getTestTable();
        $column = TextColumn::make('name')->sortable();

        $table->columns([$column]);

        $sortableColumn = $table->getSortableColumn('name');

        $this->assertSame($column, $sortableColumn);
    }

    /** @test */
    public function it_returns_null_for_non_sortable_column()
    {
        $table = $this->getTestTable();
        $column = TextColumn::make('name');

        $table->columns([$column]);

        $sortableColumn = $table->getSortableColumn('name');

        $this->assertNull($sortableColumn);
    }

    /** @test */
    public function it_returns_null_for_non_existent_sortable_column()
    {
        $table = $this->getTestTable();

        $this->assertNull($table->getSortableColumn('non-existent'));
    }

    /** @test */
    public function it_can_configure_reordering()
    {
        $table = $this->getTestTable();

        $result = $table->reorderable('sort_order');

        $this->assertSame($table, $result);
        $this->assertEquals('sort_order', $table->getReorderColumn());
        $this->assertTrue($table->isReorderable());
    }

    /** @test */
    public function it_can_conditionally_disable_reordering()
    {
        $table = $this->getTestTable();

        $table->reorderable('sort_order', false);

        $this->assertFalse($table->isReorderable());
    }

    /** @test */
    public function it_evaluates_closure_reorder_column()
    {
        $table = $this->getTestTable();

        $table->reorderable(fn () => 'dynamic_column');

        $this->assertEquals('dynamic_column', $table->getReorderColumn());
    }

    /** @test */
    public function it_is_not_reorderable_without_column()
    {
        $table = $this->getTestTable();

        $this->assertFalse($table->isReorderable());
    }

    /** @test */
    public function it_can_get_reorder_trigger_action()
    {
        $table = $this->getTestTable();
        $table->reorderable('sort_order');

        $action = $table->getReorderTriggerAction(false);

        $this->assertInstanceOf(Action::class, $action);
        $this->assertEquals('heroicon-m-arrows-up-down', $action->getIcon());
    }

    /** @test */
    public function it_changes_reorder_trigger_action_when_reordering()
    {
        $table = $this->getTestTable();
        $table->reorderable('sort_order');

        $action = $table->getReorderTriggerAction(true);

        $this->assertEquals('heroicon-m-check', $action->getIcon());
    }

    /** @test */
    public function it_can_check_if_currently_reordering()
    {
        $livewire = $this->getTestLivewireComponent();
        $livewire->isTableReordering = true;
        $table = new Table($livewire);

        $this->assertTrue($table->isReordering());
    }

    /** @test */
    public function it_can_get_table_page_name()
    {
        $table = $this->getTestTable();

        $pageName = $table->getTablePageName();

        $this->assertEquals('page', $pageName);
    }

    /** @test */
    public function it_renders_to_view()
    {
        $table = $this->getTestTable();

        $view = $table->render();

        $this->assertInstanceOf(View::class, $view);
    }

    /** @test */
    public function it_renders_with_table_data()
    {
        $table = $this->getTestTable();
        $table->heading('My Table');

        $view = $table->render();
        $data = $view->getData();

        $this->assertArrayHasKey('table', $data);
        $this->assertSame($table, $data['table']);
    }

    /** @test */
    public function it_converts_to_html()
    {
        $this->markTestSkipped('Skipped due to view dependencies requiring icon components');
    }

    /** @test */
    public function it_can_set_query_string_identifier()
    {
        $table = $this->getTestTable();

        $result = $table->queryStringIdentifier('custom-table');

        $this->assertSame($table, $result);
        $this->assertEquals('custom-table', $table->getQueryStringIdentifier());
    }

    /** @test */
    public function it_evaluates_closure_query_string_identifier()
    {
        $table = $this->getTestTable();

        $table->queryStringIdentifier(fn () => 'dynamic-identifier');

        $this->assertEquals('dynamic-identifier', $table->getQueryStringIdentifier());
    }

    /** @test */
    public function it_can_query_streams_entries()
    {
        $table = $this->getTestTable();

        $query = $table->query();

        $this->assertInstanceOf(\Streams\Core\Criteria\Criteria::class, $query);
    }
}
