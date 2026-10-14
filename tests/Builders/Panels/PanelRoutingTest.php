<?php

namespace Streams\Ui\Tests\Builders\Panels;

use Illuminate\Http\Request;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Illuminate\Support\Facades\Route;
use Streams\Ui\Builders\Panels\Panel;

class PanelRoutingTest extends UiTestCase
{
    public function test_panel_root_redirects_to_home_with_its_path_and_middleware(): void
    {
        UI::panel(Panel::make('admin')->default()->path('admin')->middleware(['web'])->homeUrl('/admin/dashboard'));

        require __DIR__.'/../../../resources/routes/web.php';

        $route = Route::getRoutes()->match(Request::create('/admin'));

        $this->assertSame('streams.ui.admin.home', $route->getName());
        $this->assertContains('panel:admin', $route->gatherMiddleware());
        $this->assertContains('web', $route->gatherMiddleware());
        $this->get('/admin')->assertRedirect('/admin/dashboard');
    }

    public function test_panel_routes_use_configured_domains_and_scope_custom_routes(): void
    {
        UI::panel(Panel::make('admin')->default()->path('admin')
            ->domains(['admin.example.com', 'staff.example.com'])
            ->homeUrl('/admin/dashboard')
            ->routes(function (Panel $panel): void {
                Route::get('/dashboard', fn () => $panel->getId())->name('dashboard');
            }));

        require __DIR__.'/../../../resources/routes/web.php';

        foreach (['admin.example.com', 'staff.example.com'] as $domain) {
            $route = Route::getRoutes()->match(Request::create("https://{$domain}/admin/dashboard"));
            $this->assertSame($domain, $route->getDomain());
            $this->assertSame('streams.ui.admin.dashboard', $route->getName());
            $this->assertContains('panel:admin', $route->gatherMiddleware());
            $this->get("https://{$domain}/admin")->assertRedirect('/admin/dashboard');
            $this->get("https://{$domain}/admin/dashboard")->assertOk()->assertSee('admin');
        }

        $this->get('https://other.example.com/admin')->assertNotFound();
        $this->get('https://admin.example.com/dashboard')->assertNotFound();
    }

    public function test_non_default_panel_root_boots_the_requested_panel(): void
    {
        UI::panel(Panel::make('default')->default()->path('default')->homeUrl('/default/dashboard'));
        $admin = Panel::make('admin')->path('admin')->homeUrl('/admin/dashboard');
        UI::panel($admin);

        require __DIR__.'/../../../resources/routes/web.php';

        $this->get('/admin')->assertRedirect('/admin/dashboard');
        $this->assertSame($admin, UI::currentPanel());
    }
}
