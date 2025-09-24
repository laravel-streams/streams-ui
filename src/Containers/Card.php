<?php

namespace Streams\Ui\Containers;

use Illuminate\Support\Str;
use Streams\Ui\Traits as Common;

class Card extends Section
{
    use Common\HasUrl;
    use Common\HasHeading;
    use Common\CanBeDisabled;
    use Common\HasDescription;
    
    protected string $viewIdentifier = 'card';

    protected string $view = 'ui::builders.card';

}
