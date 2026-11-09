<?php

namespace Streams\Ui\Tests\Builders\Containers;

use Livewire\Component;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Tables\Table;
use Streams\Ui\Builders\Containers\Card;
use Streams\Ui\Builders\Actions\MountableAction;

class CardTableTest extends UiTestCase
{
    /** @test */
    public function it_hosts_a_table_with_page_row_actions_without_registration(): void
    {
        $livewire = new class extends Component
        {
            use \Streams\Ui\Livewire\Tables\InteractsWithTable;
        };

        $action = MountableAction::make('view');

        $card = Card::make('members')->table(Table::make($livewire), [$action]);

        $this->assertInstanceOf(Table::class, $card->getTable());
        $this->assertSame([$action], $card->getRowActions());
    }
}
