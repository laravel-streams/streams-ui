<?php

namespace Streams\Ui\Forms;

use Streams\Ui\Support\Component;
use Streams\Ui\Support\Concerns\HasRecord;
use Streams\Ui\Support\Concerns\HasHeading;
use Streams\Ui\Support\Concerns\HasLivewire;
use Streams\Ui\Support\Concerns\HasDescription;

class Form extends Component
{
    use HasLivewire;

    use HasRecord;
    use HasHeading;
    use HasDescription;

    protected string $view = 'ui::components.form.index';

    protected string $viewIdentifier = 'form';

    public function __construct($livewire)
    {
        $this->livewire($livewire);
    }

    static public function make($livewire): static
    {
        $instance = new static($livewire);

        $instance->configure();

        return $instance;
    }
}
