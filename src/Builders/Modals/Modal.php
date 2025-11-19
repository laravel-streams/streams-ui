<?php

namespace Streams\Ui\Builders\Modals;

use Streams\Ui\Builders\Builder;
use Streams\Ui\Builders\Concerns as Common;

class Modal extends Builder
{
    use Common\HasName;
    use Common\HasHeading;
    use Common\HasComponents;
    use Common\HasDescription;

    final public function __construct(string|\Closure|null $name = null)
    {
        if (filled($name)) {
            $this->name($name);
        }
    }

    public static function make(string|\Closure|null $name = null): static
    {
        $instance = app(static::class, [
            'name' => $name,
        ]);

        $instance->configure();

        return $instance;
    }
}
