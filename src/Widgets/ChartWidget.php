<?php

namespace Streams\Ui\Widgets;

use Streams\Ui\Traits as Common;

class ChartWidget extends Widget
{
    use Traits\CanPoll;

    use Common\HasColor;
    use Common\HasHeading;
    use Common\HasDescription;

    use \Streams\Ui\Builders\Containers\Concerns\HasContainers;

    protected static string $view = 'ui::builders.chart';

    protected  static string $type = 'line';

    protected static array $options = [];

    protected static array $callbacks = [];
    
    protected static array $functions = [];

    public function getType(): string
    {
        return static::$type;
    }

    public function getData(): array
    {
        return [];
    }

    public function getOptions(): array
    {
        return static::$options;
    }
    
    public function getCallbacks(): array
    {
        return static::$callbacks;
    }

    public function getFunctions(): array
    {
        return static::$functions;
    }
}
