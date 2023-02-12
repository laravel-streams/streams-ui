<?php

namespace Streams\Ui;

use Livewire\Livewire;
use Streams\Core\Field\Field;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Streams\Core\Support\Facades\Assets;

class UiServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->registerConfig();
        $this->registerAdmin();

        Field::macro('input', $this->app[\Streams\Ui\Support\Macros\FieldInput::class]());
    }

    public function boot()
    {
        View::addNamespace('ui', __DIR__ . '/../resources/views');

        Lang::addNamespace('ui', realpath(base_path('vendor/streams/ui/resources/lang')));
        
        $this->publishes([
            __DIR__ . '/../resources/public' => public_path('vendor/streams/ui'),
        ], 'public');

        Assets::addPath('ui', 'vendor/streams/ui');

        Assets::register('streams.ui.css/theme.css');
        Assets::register('streams.ui.css/tailwind.css');
        Assets::register('streams.ui.css/variables.css');

        Assets::register('streams.ui.js/index.js');

        foreach (config('streams.ui.components') as $component => $class) {
            Livewire::component($component, $class);
        }
    }

    protected function registerConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/../resources/config/ui.php', 'streams.ui');

        file_exists($config = base_path('config/streams/ui.php')) ?
            $this->mergeConfigFrom($config, 'streams.ui') : null;

        $this->publishes([
            __DIR__ . '/../resources/config/ui.php' => config_path('streams/ui.php'),
        ], 'config');
    }

    protected function registerAdmin()
    {
        Route::any('admin/logout', \Streams\Ui\Http\Controllers\Logout::class);

        Route::get('admin', \Streams\Ui\Components\Admin\AdminDashboard::class);
        Route::get('admin/{section}', \Streams\Ui\Components\Admin\AdminDashboard::class);
        Route::get('admin/{section}/{action}', \Streams\Ui\Components\Admin\AdminDashboard::class);

    }
}
