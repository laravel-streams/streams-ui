<?php

namespace Streams\Ui\Builders\Containers;

use Streams\Ui\Builders\Concerns as Common;

class Grid extends Container
{
    use Traits\HasColumns;
    
    use Common\HasUrl;
    use Common\HasHeading;
    use Common\HasDescription;
    use Common\CanBeDisabled;

    protected string $viewIdentifier = 'grid';

    protected string $view = 'ui::builders.grid';

    public function __construct(string $id)
    {
        $this->id($id);
    }

    public static function make(?string $id = null): static
    {
        $static = app(static::class, ['id' => $id]);

        $static->configure();

        return $static;
    }
}
