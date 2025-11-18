<?php

namespace Streams\Ui\Notifications;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

class NotificationsManager
{
    protected Collection $notifications;

    public function __construct()
    {
        $this->notifications = new Collection;
    }

    public function put(string $id, array $notification): void
    {
        $this->notifications->put($id, $notification);

        // Also share with views so they're immediately available
        View::share('notifications', $this->all());
    }

    public function all(): array
    {
        return $this->notifications->toArray();
    }

    public function get(string $id): ?array
    {
        return $this->notifications->get($id);
    }

    public function forget(string $id): void
    {
        $this->notifications->forget($id);
        View::share('notifications', $this->all());
    }

    public function flush(): void
    {
        $this->notifications = new Collection;
        View::share('notifications', []);
    }
}
