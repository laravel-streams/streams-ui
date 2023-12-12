<?php

namespace Streams\Ui\Builders\Menu;

use Streams\Ui\Builders\Builder;
use Streams\Ui\Builders\Concerns;
use Illuminate\Support\Facades\App;

class MenuItem extends Builder
{
    use Concerns\HasUrl;
    use Concerns\HasIcon;
    use Concerns\HasSort;
    use Concerns\HasColor;
    use Concerns\HasLabel;
    use Concerns\HasBadge;
    use Concerns\HasVisibility;

    public static function make(): static
    {
        $static = App::make(static::class);

        $static->configure();

        return $static;
    }
}
