<?php

namespace Streams\Ui\Notifications;

use Streams\Ui\Builders\Builder;
use Streams\Ui\Traits as Common;
use Illuminate\Support\Facades\App;
use Streams\Ui\Support\Facades\Notifications;

class Notification extends Builder
{
    use Traits\HasDuration;

    use Common\HasIcon;
    use Common\HasTitle;
    use Common\HasColor;
    use Common\HasActions;
    use Common\HasIconColor;
    use Common\HasDescription;

    public function __construct(?string $title = null)
    {
        if ($title) {
            $this->title($title);
        }
    }

    static public function make(?string $title = null): static
    {
        $instance = App::make(static::class, [
            'title' => $title,
        ]);

        $instance->configure();

        return $instance;
    }

    public function send(): void
    {
        Notifications::add($this);
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
