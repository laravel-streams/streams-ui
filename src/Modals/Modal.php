<?php

namespace Streams\Ui\Modals;

use Streams\Ui\Builders\Builder;
use Streams\Ui\Traits as Common;

class Modal extends Builder
{
    use Common\HasName;
    use Common\HasHeading;
    use Common\HasComponents;
    use Common\HasDescription;

    final public function __construct(string | \Closure | null $name = null)
    {
        if (filled($name)) {
            $this->name($name);
        }
    }

    public static function make(string | \Closure | null $name = null): static
    {
        $static = new static($name);

        $static->configure();

        return $static;
    }
}
