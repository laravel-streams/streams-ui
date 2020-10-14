<?php

use Illuminate\Support\Facades\Route;

Route::get(
    'entry/handle/restore/{addon}/{stream}/{id}',
    'Streams\Core\Http\Controller\EntryController@restore'
);

Route::get(
    'entry/handle/export/{addon}/{stream}',
    'Streams\Core\Http\Controller\EntryController@export'
);
