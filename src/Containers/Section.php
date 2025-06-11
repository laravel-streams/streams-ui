<?php

namespace Streams\Ui\Containers;

use Streams\Ui\Traits as Common;

class Section extends Container
{
    use Common\HasUrl;
    use Common\HasHeading;
    use Common\CanBeDisabled;
    use Common\HasDescription;
    
    protected string $viewIdentifier = 'section';

    protected string $view = 'ui::builders.section';

    public function __construct(string $id)
    {
        $this->id($id);
        $this->statePath($id);
    }

    public static function make(string $id): static
    {
        $static = app(static::class, ['id' => $id]);

        $static->configure();

        return $static;
    }
}
