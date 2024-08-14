<?php

namespace Streams\Ui\Panels;

use Streams\Ui\Traits as Common;
use Illuminate\Support\Facades\View;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Support\Facades\Colors;

class Panel extends ViewBuilder
{
    use Common\HasId;
    use Common\HasColors;
    use Common\HasActions;
    use Common\CanBeDefault;
    use Common\HasNavigationGroups;

    use Traits\CanBeSpa;

    use Traits\HasPages;
    use Traits\HasLayout;
    use Traits\HasRoutes;
    use Traits\HasTenant;
    use Traits\HasFavicon;
    use Traits\HasUserMenu;
    use Traits\HasUserName;
    use Traits\HasBrandLogo;
    use Traits\HasBrandName;
    use Traits\HasResources;
    use Traits\HasUserAvatar;
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
        $instance = app(static::class, [
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
        Colors::register($this->colors);

        $variables = [];

        foreach (Colors::getColors() as $name => $shades) {
            foreach ($shades as $shade => $color) {
                $variables["{$name}-{$shade}"] = $color;
            }
        }

        View::share('cssVariables', $variables);

        View::share('spaEnabled', $this->isSpa());
        
        // Register Icons??
        // Set SPA Mode
    }
}
