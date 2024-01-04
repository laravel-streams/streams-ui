<?php

namespace Streams\Ui\Actions;

use Streams\Ui\Builders\Concerns;
use Streams\Ui\Builders\ViewBuilder;

class ActionGroup extends ViewBuilder
{
    use Concerns\HasLabel;
    use Concerns\HasActions;

    public function __construct(array $actions)
    {
        $this->actions($actions);
    }

    public static function make(array $actions): static
    {
        $static = app(static::class, ['actions' => $actions]);
        
        $static->configure();

        return $static;
    }

    protected function setUp(): void
    {
        parent::setUp();

        //$this->iconButton();
    }
}
