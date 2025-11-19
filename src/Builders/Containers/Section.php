<?php

namespace Streams\Ui\Builders\Containers;

use Illuminate\Support\Str;
use Streams\Ui\Builders\Concerns as Common;

class Section extends Container
{
    use Common\HasUrl;
    use Common\HasActions;
    use Common\HasHeading;
    use Common\HasDescription;
    use Common\CanBeDisabled;

    protected string $viewIdentifier = 'section';

    protected string $view = 'ui::builders.section';

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
