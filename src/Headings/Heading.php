<?php

namespace Streams\Ui\Headings;

use Streams\Ui\Traits as Common;
use Streams\Ui\Builders\ViewBuilder;

class Heading extends ViewBuilder
{
    use Common\HasUrl;
    use Common\HasIcon;
    use Common\HasBadge;
    use Common\HasTitle;
    use Common\HasActions;
    use Common\HasDescription;
    use Common\HasHtmlAttributes;
    
    protected string $viewIdentifier = 'heading';

    protected string $view = 'ui::builders.heading';

    final public function __construct(string | \Closure | null $title = null)
    {
        if (filled($title)) {
            $this->title($title);
        }
    }

    public static function make(string | \Closure | null $title = null): static
    {
        $static = new static($title);

        $static->configure();

        return $static;
    }
}
