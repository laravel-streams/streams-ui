<?php

namespace Streams\Ui\Builders\Modals;

use Streams\Ui\Builders\Builder;
use Streams\Ui\Builders\Concerns as Common;

class Modal extends Builder
{
    use Common\HasComponents;
    use Common\HasDescription;
    use Common\HasHeading;
    use Common\HasName;

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
