<?php

namespace Streams\Ui\Tables;

use Streams\Ui\Tables\Concerns;
use Streams\Ui\Support\Component;
use Streams\Ui\Support\Concerns\HasHeading;
use Streams\Ui\Support\Concerns\HasLivewire;
use Streams\Ui\Support\Concerns\HasDescription;

class Table extends Component
{
    use HasLivewire;

    use HasHeading;
    use HasDescription;
    
    use Concerns\HasQuery;
    use Concerns\HasActions;
    use Concerns\HasColumns;

    protected string $view = 'ui::components.tables.index';

    protected string $viewIdentifier = 'table';

    public function __construct($livewire)
    {
        $this->livewire($livewire);
    }

    static public function make($livewire): static
    {
        $instance = new static($livewire);

        //$instance->configure();

        return $instance;
    }
}
