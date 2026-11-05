<?php

namespace Streams\Ui\Tests\Livewire\Pages;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Streams\Ui\Builders\Panels\Panel;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Tests\Fixtures\Todos\TodoResource;
use Streams\Ui\Tests\Fixtures\Todos\Pages\EditTodo;
use Streams\Ui\Tests\Fixtures\Todos\Pages\CreateTodo;

/**
 * Drives the stock resource pages (ListEntries, CreateEntry, EditEntry)
 * against a real stream, including one full HTTP render through the panel layout.
 */
class ResourcePagesTest extends UiTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
        $this->withoutVite();

        File::deleteDirectory($this->dataPath());

        $this->defineStream('todos', [
            'config' => ['source' => ['type' => 'filebase']],
            'fields' => [
                'id' => ['type' => 'uuid', 'config' => ['default' => true]],
                'description' => ['type' => 'string', 'required' => true],
                'completed' => ['type' => 'boolean', 'config' => ['default' => false]],
            ],
        ]);

        UI::panel(
            Panel::make('admin')->default()->path('admin')->middleware(['web'])
                ->resources([TodoResource::class])
        );

        require __DIR__.'/../../../resources/routes/web.php';

        Route::getRoutes()->refreshNameLookups();
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->dataPath());

        parent::tearDown();
    }

    protected function dataPath(): string
    {
        return base_path(config('streams.core.data_path').'/todos');
    }

    /** @test */
    public function the_list_page_renders_through_the_panel_layout(): void
    {
        $this->createEntry('todos', ['description' => 'Buy groceries']);

        $this->get('/admin/todos')
            ->assertOk()
            ->assertSee('Buy groceries');
    }

    /** @test */
    public function the_create_page_saves_an_entry(): void
    {
        Livewire::test(CreateTodo::class)
            ->set('data.description', 'Write tests')
            ->call('save', false)
            ->assertHasNoErrors();

        $this->assertNotNull(Streams::entries('todos')->where('description', 'Write tests')->first());
    }

    /** @test */
    public function the_create_page_validates_required_fields(): void
    {
        Livewire::test(CreateTodo::class)
            ->set('data.description', '')
            ->call('save', false)
            ->assertHasErrors();

        $this->assertSame(0, Streams::entries('todos')->count());
    }

    /** @test */
    public function the_edit_page_fills_and_saves_an_entry(): void
    {
        $entry = $this->createEntry('todos', ['description' => 'Draft']);

        Livewire::test(EditTodo::class, ['entry' => $entry->id])
            ->assertSet('data.description', 'Draft')
            ->set('data.description', 'Final')
            ->call('save', false)
            ->assertHasNoErrors();

        $this->assertSame('Final', Streams::entries('todos')->find($entry->id)->description);
    }
}
