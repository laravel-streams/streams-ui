<?php

namespace Streams\Ui\Builders\Containers;

use Streams\Ui\Builders\Concerns as Common;

class Card extends Section
{
    use Common\CanBeDisabled;
    use Common\HasBadge;
    use Common\HasDescription;
    use Common\HasHeading;
    use Common\HasUrl;

    protected string $viewIdentifier = 'card';

    protected string $view = 'ui::builders.card';
}
