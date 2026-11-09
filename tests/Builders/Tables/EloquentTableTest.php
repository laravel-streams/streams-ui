<?php

namespace Streams\Ui\Tests\Builders\Tables;

use Livewire\Component;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Resources\Resource;
use Streams\Ui\Builders\Tables\Table;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Streams\Ui\Builders\Tables\Columns\LinkColumn;
use Streams\Ui\Builders\Tables\Columns\TextColumn;
use Streams\Ui\Builders\Tables\Filters\TextFilter;

class AcmeWidget extends Model
{
    protected $table = 'acme_widgets';

    protected $guarded = [];

    public $timestamps = false;
}

class AcmeWidgetResource extends Resource
{
    protected static ?string $model = AcmeWidget::class;
}

class EloquentTableTest extends UiTestCase
{
    protected function defineEnvironment($app)
    {
        $app['config']->set('database.default', 'eloquent_testing');
        $app['config']->set('database.connections.eloquent_testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('acme_widgets', function ($table) {
            $table->id();
            $table->string('name');
        });

        foreach (['Alpha', 'Bravo', 'Charlie'] as $name) {
            AcmeWidget::create(['name' => $name]);
        }
    }

    protected function makeTable(): Table
    {
        $component = new class extends Component
        {
            use \Streams\Ui\Livewire\Tables\InteractsWithTable;
        };

        $component->bootedInteractsWithTable();

        $table = $component->getTable();

        return $table
            ->query(fn () => AcmeWidget::query())
            ->columns([
                TextColumn::make('name')->sortable(),
                LinkColumn::make('id'),
            ]);
    }

    /** @test */
    public function it_lists_eloquent_rows_as_models()
    {
        $entries = $this->makeTable()->getEntries();

        $this->assertCount(3, $entries);
        $this->assertInstanceOf(AcmeWidget::class, $entries->first());
    }

    /** @test */
    public function it_filters_eloquent_rows()
    {
        $table = $this->makeTable();
        $table->filters([TextFilter::make('name')]);
        $table->setFilterValue('name', 'Bra');

        $this->assertSame(['Bravo'], $table->getEntries()->pluck('name')->all());
    }

    /** @test */
    public function it_sorts_eloquent_rows()
    {
        $table = $this->makeTable();
        $table->setState('sort', ['column' => 'name', 'direction' => 'desc']);

        $this->assertSame(['Charlie', 'Bravo', 'Alpha'], $table->getEntries()->pluck('name')->all());
    }

    /** @test */
    public function it_builds_row_urls_for_models()
    {
        $table = $this->makeTable()->entryUrl(fn ($entry) => '/widgets/'.$entry->getKey());

        $this->assertSame('/widgets/1', $table->getEntryUrl($table->getEntries()->first()));
    }

    /** @test */
    public function resource_scopes_query_and_binds_route_key()
    {
        $this->assertSame(AcmeWidget::class, AcmeWidgetResource::getModel());
        $this->assertSame(3, AcmeWidgetResource::scopedQuery()->count());

        $widget = AcmeWidgetResource::resolveModelRouteBinding(2);

        $this->assertInstanceOf(AcmeWidget::class, $widget);
        $this->assertSame('Bravo', $widget->name);
        $this->assertSame('Bravo', AcmeWidgetResource::resolveRecord('2')->name);
    }

    /** @test */
    public function card_and_form_builders_accept_model_records()
    {
        $widget = AcmeWidget::find(1);

        $card = \Streams\Ui\Builders\Forms\Form::make('widget')->entry($widget);

        $this->assertSame(1, $card->getEntry());
        $this->assertSame($widget, $card->getEntryInstance());

        $page = new \Streams\Ui\Livewire\Pages\EditEntry;
        $page->entry($card->getEntryInstance());

        $method = new \ReflectionMethod($page, 'handleRecordUpdate');
        $method->setAccessible(true);
        $method->invoke($page, $page->getEntryInstance(), ['name' => 'Renamed']);

        $this->assertSame('Renamed', AcmeWidget::find(1)->name);
    }

    /** @test */
    public function form_handle_saves_a_model_attribute()
    {
        $form = new class('widget') extends \Streams\Ui\Builders\Forms\Form
        {
            public function handle(array $payload = [])
            {
                $this->getEntryInstance()->update($payload);
            }
        };
        $form->entry(AcmeWidget::find(2));

        $form->handle(['name' => 'FormSaved']);

        $this->assertSame('FormSaved', AcmeWidget::find(2)->name);
    }

    /** @test */
    public function card_section_saves_a_model_attribute()
    {
        $form = \Streams\Ui\Builders\Forms\Form::make('widget')->entry(AcmeWidget::find(3));
        $card = \Streams\Ui\Builders\Containers\Card::make('widget')->components([$form]);

        $hosted = $card->getComponents()[0];
        $this->assertInstanceOf(AcmeWidget::class, $hosted->getEntryInstance());

        $hosted->getEntryInstance()->update(['name' => 'CardSaved']);

        $this->assertSame('CardSaved', AcmeWidget::find(3)->name);
    }
}
