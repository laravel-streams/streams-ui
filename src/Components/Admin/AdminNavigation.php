<?php

namespace Streams\Ui\Components\Admin;

use Streams\Ui\Components\Navigation;
use Streams\Ui\Components\Admin\Workflows\NavigationBuilder;

class AdminNavigation extends Navigation
{
    public ?string $builder = NavigationBuilder::class;
}
