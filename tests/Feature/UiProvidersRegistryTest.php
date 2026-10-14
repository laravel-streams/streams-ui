<?php

namespace Streams\Ui\Tests\Feature;

use Livewire\Livewire;
use Livewire\Component;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Livewire\Pages\Page;
use Streams\Ui\Builders\Tables\Table;
use Streams\Ui\Builders\Actions\Action;
use Streams\Ui\Livewire\Pages\EditEntry;
use Streams\Ui\Http\Middleware\SetUpPanel;
use Streams\Ui\Livewire\Pages\CreateEntry;
use Streams\Ui\Livewire\Pages\ListEntries;
use Streams\Ui\Livewire\Forms\InteractsWithForms;
use Streams\Ui\Livewire\Tables\InteractsWithTable;

class UiProvidersRegistryTest extends UiTestCase
{
    /** @test */
    public function test_page_uses_documented_table_and_action_traits(): void
    {
        $actionTrait = 'Streams\\Ui\\Builders\\Actions\\Contracts\\InteractsWithActions';

        $this->assertTrue(trait_exists($actionTrait), 'Documented action trait namespace is missing.');

        $pageTraits = class_uses(Page::class);

        $this->assertContains(InteractsWithTable::class, $pageTraits);
        $this->assertContains($actionTrait, $pageTraits);
        $this->assertContains(InteractsWithTable::class, class_uses(ListEntries::class));
        $this->assertContains(InteractsWithForms::class, class_uses(CreateEntry::class));
        $this->assertContains(InteractsWithForms::class, class_uses(EditEntry::class));

        $this->assertContains(SetUpPanel::class, Livewire::getPersistentMiddleware());
        $this->assertSame(SetUpPanel::class, app('router')->getMiddleware()['panel'] ?? null);

        $component = new class extends Component
        {
            use InteractsWithTable;
            use \Streams\Ui\Builders\Actions\Contracts\InteractsWithActions;

            public function table(Table $table): Table
            {
                return $table;
            }

            public function getActions(): array
            {
                return [
                    Action::make('save'),
                ];
            }
        };

        $component->bootedInteractsWithTable();

        $this->assertInstanceOf(Table::class, $component->getTable());
        $this->assertSame('save', $component->getAction('save')->getName());
    }
}
