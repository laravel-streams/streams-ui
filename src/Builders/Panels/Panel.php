<?php

namespace Streams\Ui\Builders\Panels;

use Streams\Ui\Builders;
use Streams\Ui\Builders\Panels;
use Streams\Ui\Builders\Builder;
use Illuminate\Support\Facades\App;

class Panel extends Builder
{
    use Builders\Concerns\HasId;

    use Builders\Concerns\CanBeDefault;

    use Panels\Concerns\HasPages;
    use Panels\Concerns\HasLayout;
    use Panels\Concerns\HasRoutes;
    use Panels\Concerns\HasUserMenu;
    use Panels\Concerns\HasResources;
    use Panels\Concerns\HasMiddleware;
    use Panels\Concerns\HasNavigation;
    use Panels\Concerns\HasLivewireComponents;

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
