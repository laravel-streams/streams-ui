<?php

namespace Streams\Ui\Builders\Navigation;

use Illuminate\Support\Facades\App;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns as Common;

class ProgressBar extends ViewBuilder
{
    use Common\HasId;
    use Common\HasLabel;
    use Common\HasHtmlAttributes;

    protected string $viewIdentifier = 'progressBar';

    protected string $view = 'ui::builders/progress-bar';

    protected array|\Closure $steps = [];
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
        return $this->evaluate($this->steps);
    }

    /**
     * Set the progress for the progress bar
     */
    public function progress(int|\Closure $progress): static
    {
        $this->progress = $progress;

        return $this;
    }

    /**
     * Get the steps for the progress bar
     */
    public function getProgress(): int
    {
        return $this->evaluate($this->progress);
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
