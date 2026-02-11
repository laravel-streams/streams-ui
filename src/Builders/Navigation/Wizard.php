<?php

namespace Streams\Ui\Builders\Navigation;

use Illuminate\Support\Facades\App;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns as Common;

class Wizard extends ViewBuilder
{
    use Common\HasId;
    use Common\HasLabel;
    use Common\HasSteps;
    use Common\HasHeading;
    use Common\HasDescription;
    use Common\HasHtmlAttributes;

    protected string $viewIdentifier = 'wizard';

    protected string $view = 'ui::builders/wizard';

    final public function __construct(?string $id = null)
    {
        if ($id) {
            $this->id($id);
        }
    }

    public static function make(?string $id = null): static
    {
        $instance = App::make(static::class, [
            'id' => $id ?: 'progress-bar-' . uniqid(),
        ]);

        $instance->configure();

        return $instance;
    }
}
