<?php

namespace Streams\Ui\Builders\Panels;

use Illuminate\Support\Facades\View;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Support\Facades\Colors;
use Streams\Ui\Builders\Concerns as Common;

class Panel extends ViewBuilder
{
    use Common\HasId;
    use Common\HasActions;
    // use Common\HasNavigationGroups;
    use Common\CanBeDefault;

    use Traits\CanBeSpa;

    use Traits\HasPages;
    use Traits\HasColors;
    use Traits\HasLayout;
    use Traits\HasRoutes;
    use Traits\HasTenant;
    use Traits\HasFavicon;
    use Traits\HasUserMenu;
    use Traits\HasUserName;
    use Traits\HasBrandLogo;
    use Traits\HasBrandName;
    use Traits\HasResources;
    use Traits\HasMiddleware;
    use Traits\HasNavigation;
    use Traits\HasUserAvatar;
    use Traits\HasLivewireComponents;

    public function __construct(?string $id = null)
    {
        if ($id) {
            $this->id($id);
        }
    }

    public static function make(?string $id = null): static
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
        // $this->registerLivewirePersistentMiddleware();
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
