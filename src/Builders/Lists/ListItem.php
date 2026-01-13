<?php

namespace Streams\Ui\Builders\Lists;

use Illuminate\Support\Facades\App;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns as Common;

class ListItem extends ViewBuilder
{
    use Common\HasActions;
    use Common\HasDescription;
    use Common\HasHtmlAttributes;
    use Common\HasIcon;
    use Common\HasId;
    use Common\HasTitle;

    protected string $view = 'ui::components.lists.list-item';

    public function __construct(?string $id = null)
    {
        if ($id) {
            $this->id($id);
        }
    }

    public static function make(?string $id = null): static
    {
        $instance = App::make(static::class, [
            'id' => $id ?: 'list-item-'.uniqid(),
        ]);

        $instance->configure();

        return $instance;
    }

    /**
     * Get the view data
     */
    public function getViewData(): array
    {
        return array_merge([
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'icon' => $this->getIcon(),
            'actions' => $this->getActions(),
            'htmlAttributes' => $this->getHtmlAttributeBag(),
        ], $this->viewData);
    }
}
