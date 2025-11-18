<?php

namespace Streams\Ui\Builders\Panels;

use Streams\Ui\Traits as Common;
use Illuminate\Support\Facades\View;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Support\Facades\Colors;

class Panel extends ViewBuilder
{
    use Common\CanBeDefault;
    use Common\HasActions;
    use Common\HasColors;
    use Common\HasId;
    use Common\HasNavigationGroups;
    use Traits\CanBeSpa;
    use Traits\HasBrandLogo;
    use Traits\HasBrandName;
    use Traits\HasFavicon;
    use Traits\HasLayout;
    use Traits\HasLivewireComponents;
    use Traits\HasMiddleware;
    use Traits\HasNavigation;
    use Traits\HasPages;
    use Traits\HasResources;
    use Traits\HasRoutes;
    use Traits\HasTenant;
    use Traits\HasUserAvatar;
    use Traits\HasUserMenu;
    use Traits\HasUserName;

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
