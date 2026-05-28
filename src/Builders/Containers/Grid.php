<?php

namespace Streams\Ui\Builders\Containers;

use Illuminate\Support\Str;
use Streams\Ui\Builders\Concerns as Common;

class Grid extends Container
{
    use Common\CanBeDisabled;
    use Common\HasDescription;
    use Common\HasHeading;
    use Common\HasUrl;
    use Concerns\HasColumns;

    protected string $viewIdentifier = 'grid';

    protected string $view = 'ui::builders.grid';

    public function __construct(string $id)
    {
        $this->id($id);
    }

    public static function make(?string $id = null): static
    {
        $static = app(static::class, ['id' => $id ?: Str::random(10)]);

        $static->configure();

        return $static;
    }
}
