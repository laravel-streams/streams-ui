<?php

namespace Streams\Ui\Panels;

use Streams\Ui\Traits as Common;
use Illuminate\Support\Facades\App;
use Streams\Ui\Builders\ViewBuilder;

class Panel extends ViewBuilder
{
    use Common\HasId;
    use Common\CanBeDefault;

    use Traits\HasPages;
    use Traits\HasLayout;
    use Traits\HasRoutes;
    use Traits\HasUserMenu;
    use Traits\HasResources;
    use Traits\HasMiddleware;
    use Traits\HasNavigation;
    use Traits\HasLivewireComponents;

    public function __construct(?string $id = null)
    {
        if ($id) {
            $this->id($id);
        }
    }

    static public function make(?string $id = null): static
    {
        $instance = App::make(static::class, [
            'id' => $id,
        ]);

        $instance->configure();

        return $instance;
    }

    public function register(): void
    {
        $this->registerLivewireComponents();
        //$this->registerLivewirePersistentMiddleware();
    }

    public function boot(): void
    {
        // Register Colors
        // Register Icons??
        // Set SPA Mode
    }
}
