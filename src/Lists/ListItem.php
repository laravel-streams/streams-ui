<?php

namespace Streams\Ui\Lists;

use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Traits as Common;
use Illuminate\Support\Facades\App;

class ListItem extends ViewBuilder
{
    use Common\HasId;
    use Common\HasTitle;
    use Common\HasDescription;
    use Common\HasIcon;
    use Common\HasActions;
    use Common\HasHtmlAttributes;

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
            'id' => $id ?: 'list-item-' . uniqid(),
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
