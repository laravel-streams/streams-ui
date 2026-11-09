<?php

namespace Streams\Ui\Builders\Containers;

use Streams\Ui\Builders\Concerns as Common;
use Streams\Ui\Builders\Tables\Table;
use Streams\Ui\Builders\Actions\MountableAction;

class Card extends Section
{
    use Common\CanBeDisabled;
    use Common\HasBadge;
    use Common\HasDescription;
    use Common\HasHeading;
    use Common\HasUrl;

    protected string $viewIdentifier = 'card';

    protected string $view = 'ui::builders.card';

    /**
     * Host a Table in the card. Row actions (including page
     * MountableActions) mount against the table's livewire
     * component with the row entry; no registration needed.
     */
    public function table(Table $table, array $rowActions = []): static
    {
        if ($rowActions) {
            $table->actions($rowActions);
        }

        $this->components([...$this->getComponents(), $table]);

        return $this;
    }

    public function getTable(): ?Table
    {
        return collect($this->getComponents())->first(fn ($c) => $c instanceof Table);
    }

    public function getRowActions(): array
    {
        return array_values(array_filter(
            $this->getTable()?->getActions() ?? [],
            fn ($a) => $a instanceof MountableAction
        ));
    }
}
