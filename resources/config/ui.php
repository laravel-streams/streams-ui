<?php

use Streams\Ui\Input;

return [
    'inputs' => [
        'text' => Input\Input::class,
        'hash' => Input\Input::class,
        'input' => Input\Input::class,
        'string' => Input\Input::class,
    
        'date' => Input\Date::class,
        'time' => Input\Time::class,
        'datetime' => Input\Datetime::class,
    
        'slug' => Input\Slug::class,
    
        'color' => Input\Color::class,
        'radio' => Input\Radio::class,
        'range' => Input\Range::class,
    
        'select' => Input\Select::class,
    
        'integer' => Input\Integer::class,
        'decimal' => Input\Decimal::class,
    
        'textarea' => Input\Textarea::class,
        'markdown' => Input\Markdown::class,
    
        'file' => Input\File::class,
        'image' => Input\Image::class,
    
        'relationship' => Input\Relationship::class,
    
        'boolean' => Input\Toggle::class,
    ],
];
