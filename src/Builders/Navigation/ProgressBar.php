<?php

namespace Streams\Ui\Builders\Navigation;

use Illuminate\Support\Facades\App;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns as Common;

class ProgressBar extends ViewBuilder
{
    use Common\HasId;
    use Common\HasLabel;
    use Common\HasHeading;
    use Common\HasDescription;
    use Common\HasHtmlAttributes;

    protected string $viewIdentifier = 'progressBar';

    protected string $view = 'ui::builders/progress-bar';

    protected int|\Closure $progress = 0;

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

    public function progress(int|\Closure $progress): static
    {
        $this->progress = $progress;

        return $this;
    }

    public function getProgress(): int
    {
        return $this->evaluate($this->progress);
    }
}
