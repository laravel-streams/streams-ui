<?php

namespace Streams\Ui\Menu;

use Streams\Ui\Traits as Common;
use Streams\Ui\Builders\Builder;
use Illuminate\Support\Facades\App;

class MenuItem extends Builder
{
    use Common\HasUrl;
    use Common\HasIcon;
    use Common\HasSort;
    use Common\HasColor;
    use Common\HasLabel;
    use Common\HasBadge;
    use Common\CanBeHidden;

    public static function make(): static
    {
        $static = App::make(static::class);

        $static->configure();

        return $static;
    }
}
