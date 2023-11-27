<?php

namespace Streams\Ui\Forms;

use Streams\Ui\Forms\Concerns;
use Streams\Ui\Support\ViewComponent;
use Streams\Ui\Support\Concerns\HasEntry;
use Streams\Ui\Support\Concerns\HasHeading;
use Streams\Ui\Support\Concerns\HasLivewire;
use Streams\Ui\Support\Concerns\HasDescription;

class Form extends ViewComponent
{
    use HasLivewire;

    use HasEntry;
    use HasHeading;
    use HasDescription;
    
    use Concerns\HasComponents;

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
