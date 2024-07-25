<?php

namespace Streams\Ui\Notifications;

use Illuminate\Support\Str;
use Streams\Ui\Traits as Common;
use Illuminate\Support\Facades\App;
use Streams\Ui\Builders\ViewBuilder;
use Illuminate\Support\Facades\Session;

class Notification extends ViewBuilder
{
    use Traits\HasDuration;

    use Common\HasId;
    use Common\HasIcon;
    use Common\HasTitle;
    use Common\HasColor;
    use Common\HasActions;
    use Common\HasIconColor;
    use Common\HasDescription;

    protected string $view = 'ui::notification';

    public function __construct(string $id)
    {
        $this->id($id);
    }

    static public function make(?string $id = null): static
    {
        $instance = App::make(static::class, [
            'id' => $id ?: Str::orderedUuid(),
        ]);

        $instance->configure();

        return $instance;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            // 'actions' => array_map(fn (Action | ActionGroup $action): array => $action->toArray(), $this->getActions()),
            'view' => $this->getView(),
            'icon' => $this->getIcon(),
            'color' => $this->getColor(),
            'title' => $this->getTitle(),
            'duration' => $this->getDuration(),
            'iconColor' => $this->getIconColor(),
            'description' => $this->getDescription(),
            // 'viewData' => $this->getViewData(),
        ];
    }

    public static function fromArray(array $data): static
    {
        $static = static::make($data['id'] ?? Str::random());

        // If the container constructs an instance of child class
        // instead of the current class, we should run `fromArray()`
        // on the child class instead.
        // if (
        //     ($static::class !== self::class) &&
        //     (get_called_class() === self::class)
        // ) {
        //     return $static::fromArray($data);
        // }

        // $static->actions(
        //     array_map(
        //         fn (array $action): Action | ActionGroup => match (array_key_exists('actions', $action)) {
        //             true => ActionGroup::fromArray($action),
        //             false => Action::fromArray($action),
        //         },
        //         $data['actions'] ?? [],
        //     ),
        // );

        if ($view = $data['view'] ?? null) {
            $static->view($view);
        }

        // $static->viewData($data['viewData'] ?? []);
        $static->icon($data['icon'] ?? null);
        $static->color($data['color'] ?? null);
        $static->title($data['title'] ?? null);
        $static->duration($data['duration'] ?? null);
        $static->iconColor($data['iconColor'] ?? null);
        $static->description($data['description'] ?? null);

        return $static;
    }

    // public function push(): static
    // {
    //     Notifications::push($this->toArray());

    //     return $this;
    // }

    public function send(): static
    {
        Session::push(
            'streams.notifications',
            $this->toArray(),
        );

        return $this;
    }

    public function danger(): static
    {
        $this->icon('heroicon-o-x-circle');
        $this->iconColor('danger');

        return $this;
    }

    public function info(): static
    {
        $this->icon('heroicon-o-information-circle');
        $this->iconColor('info');

        return $this;
    }

    public function success(): static
    {
        $this->icon('heroicon-o-check-circle');
        $this->iconColor('success');

        return $this;
    }

    public function warning(): static
    {
        $this->icon('heroicon-o-exclamation-circle');
        $this->iconColor('warning');

        return $this;
    }
}
