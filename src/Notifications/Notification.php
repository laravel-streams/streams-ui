<?php

namespace Streams\Ui\Notifications;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Streams\Ui\Builders\ViewBuilder;
use Illuminate\Support\Facades\Session;
use Streams\Ui\Builders\Concerns as Common;
use Streams\Ui\Support\Facades\Notifications;

class Notification extends ViewBuilder
{
    use Common\HasId;
    use Common\HasIcon;
    use Common\HasColor;
    use Common\HasTitle;
    use Common\HasActions;
    use Concerns\HasDuration;
    use Common\HasIconColor;
    use Common\HasDescription;

    protected string $view = 'ui::notification';

    public function __construct(string $id)
    {
        $this->id($id);
    }

    public static function make(?string $id = null): static
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

    public function push(?Component $livewire = null): static
    {
        Notifications::put($this->getId(), $this->toArray());

        if ($livewire) {
            $livewire->notifications[$this->getId()] = $this->toArray();
        }

        return $this;
    }

    public function send(): static
    {
        Session::put(
            'streams.notifications.'.$this->getId(),
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
