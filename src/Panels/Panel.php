<?php

namespace Streams\Ui\Panels;

use Streams\Ui\Panels\Concerns;
use Streams\Ui\Support\Component;
use Streams\Ui\Support\Concerns\CanBeDefault;

class Panel extends Component
{
    use CanBeDefault;
    
    use Concerns\HasId;
    use Concerns\HasPages;
    use Concerns\HasLayout;
    use Concerns\HasRoutes;
    use Concerns\HasUserMenu;
    use Concerns\HasMiddleware;
    use Concerns\HasNavigation;

    static public function make(?string $id = null): static
    {
        $instance = new static;

        if ($id) {
            $instance->id($id);
        }

        //$instance->configure();

        return $instance;
    }

    public function boot(): void
    {
        // Register Colors
        // Register Icons??
        // Set SPA Mode
    }
}
