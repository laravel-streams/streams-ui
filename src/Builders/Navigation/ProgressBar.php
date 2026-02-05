<?php

namespace Streams\Ui\Builders\Navigation;

use Illuminate\Support\Facades\App;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns as Common;

class ProgressBar extends ViewBuilder
{
    use Common\HasHtmlAttributes;
    use Common\HasId;

    protected string $viewIdentifier = 'progressBar';

    protected string $view = 'ui::builders.progress-bar';

    protected array $steps = [];

    final public function __construct(?string $id = null)
    {
        if ($id) {
            $this->id($id);
        }
    }

    public static function make(?string $id = null): static
    {
        $instance = App::make(static::class, [
            'id' => $id ?: 'list-'.uniqid(),
        ]);

        $instance->configure();

        return $instance;
    }

    /**
     * Set the steps for the progress bar
     */
    public function steps(array|\Closure $steps): static
    {
        $this->steps = $steps;

        return $this;
    }

    /**
     * Get the steps for the progress bar
     */
    public function getSteps(): array
    {
        if (is_callable($this->steps)) {
            return call_user_func($this->steps);
        }

        return $this->steps;
    }

    /**
     * Get the view data
     */
    public function getViewData(): array
    {
        return array_merge([
            'id' => $this->getId(),
            'steps' => $this->getSteps(),
            'htmlAttributes' => $this->getHtmlAttributeBag(),
        ], $this->viewData);
    }
}
