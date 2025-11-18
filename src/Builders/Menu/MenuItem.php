<?php

namespace Streams\Ui\Builders\Menu;

use Streams\Ui\Builders\Builder;
use Streams\Ui\Traits as Common;
use Illuminate\Support\Facades\App;

class MenuItem extends Builder
{
    use Common\CanBeHidden;
    use Common\HasBadge;
    use Common\HasColor;
    use Common\HasHtmlAttributes;
    use Common\HasIcon;
    use Common\HasLabel;
    use Common\HasSort;
    use Common\HasUrl;

    public static function make(): static
    {
        $static = App::make(static::class);

        $static->configure();

        return $static;
    }
}
