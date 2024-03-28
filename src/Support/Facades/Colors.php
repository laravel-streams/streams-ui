<?php

namespace Streams\Ui\Support\Facades;

use Streams\Ui\Colors\ColorManager;
use Illuminate\Support\Facades\Facade;

class Colors extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'colors';
    }

    public static function register(array $colors): void
    {
        static::resolved(function (ColorManager $manager) use ($colors) {
            $manager->register($colors);
        });
    }
}
