<?php

namespace Streams\Ui\Menu;

use Streams\Ui\Menu\Concerns;
use Streams\Ui\Support\Component;
use Streams\Ui\Support\Concerns\HasUrl;
use Streams\Ui\Support\Concerns\HasIcon;
use Streams\Ui\Support\Concerns\HasSort;
use Streams\Ui\Support\Concerns\HasBadge;
use Streams\Ui\Support\Concerns\HasLabel;
use Streams\Ui\Support\Concerns\HasVisibility;

class MenuItem extends Component
{
    use HasUrl;
    use HasIcon;
    use HasSort;
    use HasLabel;
    use HasBadge;
    use HasVisibility;

    use Concerns\HasColor;

    public static function make(): static
    {
        $static = new static;

        $static->configure();

        return $static;
    }
}
