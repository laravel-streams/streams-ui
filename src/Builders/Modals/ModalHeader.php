<?php

namespace Streams\Ui\Builders\Modals;

use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns as Common;

class ModalHeader extends ViewBuilder
{
    use Common\HasActions;
    use Common\HasDescription;
    use Common\HasHtmlAttributes;
    use Common\HasIcon;
    use Common\HasTitle;

    protected string $viewIdentifier = 'modalHeader';

    protected string $view = 'ui::builders.modal-header';

    final public function __construct(string|\Closure|null $title = null)
    {
        if (filled($title)) {
            $this->title($title);
        }
    }

    public static function make(string|\Closure|null $title = null): static
    {
        $instance = app(static::class, [
            'title' => $title,
        ]);

        $instance->configure();

        return $instance;
    }
}
