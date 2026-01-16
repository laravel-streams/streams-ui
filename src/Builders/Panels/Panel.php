<?php

namespace Streams\Ui\Builders\Panels;

use Illuminate\Support\Facades\View;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Support\Facades\Colors;
use Streams\Ui\Builders\Concerns as Common;

class Panel extends ViewBuilder
{
    // use Common\HasNavigationGroups;
    
    
    use Common\HasId;
    use Common\HasActions;
    use Common\CanBeDefault;
    
    use Concerns\CanBeSpa;

    use Concerns\HasPages;
    use Concerns\HasColors;
    use Concerns\HasLayout;
    use Concerns\HasRoutes;
    use Concerns\HasTenant;
    use Concerns\HasFavicon;
    use Concerns\HasUserMenu;
    use Concerns\HasUserName;
    use Concerns\HasBrandLogo;
    use Concerns\HasBrandName;
    use Concerns\HasResources;
    use Concerns\HasMiddleware;
    use Concerns\HasNavigation;
    use Concerns\HasUserAvatar;
    use Concerns\HasLivewireComponents;

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
