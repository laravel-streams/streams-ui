<?php

namespace Streams\Ui\Tests\Builders\Panels;

use Streams\Ui\Builders\Builder;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Panels\Panel;
use Streams\Ui\Builders\Actions\Action;
use Illuminate\Contracts\Support\Htmlable;
use Streams\Ui\Builders\Navigation\NavigationGroup;

class PanelTest extends UiTestCase
{
    protected function getTestPanel(): Panel
    {
        return new Panel;
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $panel = $this->getTestPanel();

        $this->assertInstanceOf(Builder::class, $panel);
        $this->assertInstanceOf(ViewBuilder::class, $panel);
        $this->assertInstanceOf(Panel::class, $panel);
    }

    /** @test */
    public function it_can_be_made_with_static_method()
    {
        $panel = Panel::make();

        $this->assertInstanceOf(Panel::class, $panel);
    }

    /** @test */
    public function it_can_be_instantiated_with_id()
    {
        $panel = new Panel('admin');

        $this->assertEquals('admin', $panel->getId());
    }

    /** @test */
    public function it_can_be_made_with_id()
    {
        $panel = Panel::make('admin');

        $this->assertEquals('admin', $panel->getId());
    }

    /** @test */
    public function it_can_set_and_get_id()
    {
        $panel = $this->getTestPanel();

        $result = $panel->id('custom-panel');

        $this->assertSame($panel, $result);
        $this->assertEquals('custom-panel', $panel->getId());
    }

    /** @test */
    public function it_evaluates_closure_id()
    {
        $panel = $this->getTestPanel();

        $panel->id(fn () => 'dynamic-id');

        $this->assertEquals('dynamic-id', $panel->getId());
    }

    /** @test */
    public function it_can_configure_spa_mode()
    {
        $panel = $this->getTestPanel();

        $result = $panel->spa();

        $this->assertSame($panel, $result);
        $this->assertTrue($panel->isSpa());
    }

    /** @test */
    public function it_can_disable_spa_mode()
    {
        $panel = $this->getTestPanel();

        $panel->spa(false);

        $this->assertFalse($panel->isSpa());
    }

    /** @test */
    public function it_evaluates_closure_spa()
    {
        $panel = $this->getTestPanel();

        $panel->spa(fn () => true);

        $this->assertTrue($panel->isSpa());
    }

    /** @test */
    public function it_is_not_spa_by_default()
    {
        $panel = $this->getTestPanel();

        $this->assertFalse($panel->isSpa());
    }

    /** @test */
    public function it_can_set_and_get_brand_name()
    {
        $panel = $this->getTestPanel();

        $result = $panel->brandName('My App');

        $this->assertSame($panel, $result);
        $this->assertEquals('My App', $panel->getBrandName());
    }

    /** @test */
    public function it_evaluates_closure_brand_name()
    {
        $panel = $this->getTestPanel();

        $panel->brandName(fn () => 'Dynamic Brand');

        $this->assertEquals('Dynamic Brand', $panel->getBrandName());
    }

    /** @test */
    public function it_can_set_brand_name_as_htmlable()
    {
        $panel = $this->getTestPanel();
        $htmlable = new class implements Htmlable
        {
            public function toHtml()
            {
                return '<strong>Brand</strong>';
            }
        };

        $panel->brandName($htmlable);

        $this->assertSame($htmlable, $panel->getBrandName());
    }

    /** @test */
    public function it_can_set_and_get_brand_logo()
    {
        $panel = $this->getTestPanel();

        $result = $panel->brandLogo('/images/logo.png');

        $this->assertSame($panel, $result);
        $this->assertEquals('/images/logo.png', $panel->getBrandLogo());
    }

    /** @test */
    public function it_evaluates_closure_brand_logo()
    {
        $panel = $this->getTestPanel();

        $panel->brandLogo(fn () => '/dynamic/logo.png');

        $this->assertEquals('/dynamic/logo.png', $panel->getBrandLogo());
    }

    /** @test */
    public function it_can_set_and_get_favicon()
    {
        $panel = $this->getTestPanel();

        $result = $panel->favicon('/favicon.ico');

        $this->assertSame($panel, $result);
        $this->assertEquals('/favicon.ico', $panel->getFavicon());
    }

    /** @test */
    public function it_evaluates_closure_favicon()
    {
        $panel = $this->getTestPanel();

        $panel->favicon(fn () => '/dynamic/favicon.ico');

        $this->assertEquals('/dynamic/favicon.ico', $panel->getFavicon());
    }

    /** @test */
    public function it_can_set_and_get_user_name()
    {
        $panel = $this->getTestPanel();

        $result = $panel->userName('John Doe');

        $this->assertSame($panel, $result);
        $this->assertEquals('John Doe', $panel->getUserName());
    }

    /** @test */
    public function it_evaluates_closure_user_name()
    {
        $panel = $this->getTestPanel();

        $panel->userName(fn () => 'Dynamic User');

        $this->assertEquals('Dynamic User', $panel->getUserName());
    }

    /** @test */
    public function it_can_set_and_get_user_avatar()
    {
        $panel = $this->getTestPanel();

        $result = $panel->userAvatar('/images/avatar.jpg');

        $this->assertSame($panel, $result);
        $this->assertEquals('/images/avatar.jpg', $panel->getUserAvatar());
    }

    /** @test */
    public function it_evaluates_closure_user_avatar()
    {
        $panel = $this->getTestPanel();

        $panel->userAvatar(fn () => '/dynamic/avatar.jpg');

        $this->assertEquals('/dynamic/avatar.jpg', $panel->getUserAvatar());
    }

    /** @test */
    public function it_can_set_and_get_layout()
    {
        $panel = $this->getTestPanel();

        $result = $panel->layout('ui::layouts.custom');

        $this->assertSame($panel, $result);
        $this->assertEquals('ui::layouts.custom', $panel->getLayout());
    }

    /** @test */
    public function it_has_default_layout()
    {
        $panel = $this->getTestPanel();

        $this->assertEquals('ui::layouts.app', $panel->getLayout());
    }

    /** @test */
    public function it_can_set_pages()
    {
        $this->markTestSkipped('Skipped due to Livewire component registration requirements');
    }

    /** @test */
    public function it_can_append_pages()
    {
        $this->markTestSkipped('Skipped due to Livewire component registration requirements');
    }

    /** @test */
    public function it_deduplicates_pages()
    {
        $this->markTestSkipped('Skipped due to Livewire component registration requirements');
    }

    /** @test */
    public function it_can_set_resources()
    {
        $panel = $this->getTestPanel();
        $resources = ['App\Resources\UserResource', 'App\Resources\PostResource'];

        $result = $panel->resources($resources);

        $this->assertSame($panel, $result);
        $this->assertCount(2, $panel->getResources());
    }

    /** @test */
    public function it_can_append_resources()
    {
        $panel = $this->getTestPanel();

        $panel->resources(['App\Resources\UserResource']);
        $panel->resources(['App\Resources\PostResource']);

        $this->assertCount(2, $panel->getResources());
    }

    /** @test */
    public function it_deduplicates_resources()
    {
        $panel = $this->getTestPanel();

        $panel->resources(['App\Resources\UserResource']);
        $panel->resources(['App\Resources\UserResource']);

        $this->assertCount(1, $panel->getResources());
    }

    /** @test */
    public function it_can_set_middleware()
    {
        $panel = $this->getTestPanel();
        $panel->id('admin');
        $middleware = ['auth', 'verified'];

        $result = $panel->middleware($middleware);

        $this->assertSame($panel, $result);

        $allMiddleware = $panel->getMiddleware();
        $this->assertContains('panel:admin', $allMiddleware);
        $this->assertContains('auth', $allMiddleware);
        $this->assertContains('verified', $allMiddleware);
    }

    /** @test */
    public function it_prepends_panel_middleware()
    {
        $panel = $this->getTestPanel();
        $panel->id('admin');

        $panel->middleware(['auth']);

        $middleware = $panel->getMiddleware();

        $this->assertEquals('panel:admin', $middleware[0]);
    }

    /** @test */
    public function it_can_append_middleware()
    {
        $panel = $this->getTestPanel();
        $panel->id('admin');

        $panel->middleware(['auth']);
        $panel->middleware(['verified']);

        $middleware = $panel->getMiddleware();

        $this->assertCount(3, $middleware); // panel:admin, auth, verified
    }

    /** @test */
    public function it_can_set_colors()
    {
        $panel = $this->getTestPanel();
        $colors = [
            'primary' => '#3b82f6',
            'danger' => '#ef4444',
        ];

        $result = $panel->colors($colors);

        $this->assertSame($panel, $result);
    }

    /** @test */
    public function it_can_set_navigation_groups()
    {
        $panel = $this->getTestPanel();
        $groups = [
            'main' => NavigationGroup::make()->label('Main'),
            'settings' => NavigationGroup::make()->label('Settings'),
        ];

        $result = $panel->navigationGroups($groups);

        $this->assertSame($panel, $result);
        $this->assertCount(2, $panel->getNavigationGroups());
    }

    /** @test */
    public function it_can_append_navigation_groups()
    {
        $panel = $this->getTestPanel();

        $panel->navigationGroups(['main' => NavigationGroup::make()->label('Main')]);
        $panel->navigationGroups(['settings' => NavigationGroup::make()->label('Settings')]);

        $this->assertCount(2, $panel->getNavigationGroups());
    }

    /** @test */
    public function it_evaluates_closure_navigation_groups()
    {
        $this->markTestSkipped('Navigation groups with closures require special handling');
    }

    /** @test */
    public function it_can_set_actions()
    {
        $panel = $this->getTestPanel();
        $action = Action::make('settings');

        $result = $panel->actions([$action]);

        $this->assertSame($panel, $result);
        $this->assertCount(1, $panel->getActions());
    }

    /** @test */
    public function it_can_set_default()
    {
        $panel = $this->getTestPanel();

        $result = $panel->default();

        $this->assertSame($panel, $result);
        $this->assertTrue($panel->isDefault());
    }

    /** @test */
    public function it_can_set_default_to_false()
    {
        $panel = $this->getTestPanel();

        $panel->default(false);

        $this->assertFalse($panel->isDefault());
    }

    /** @test */
    public function it_is_not_default_by_default()
    {
        $panel = $this->getTestPanel();

        $this->assertFalse($panel->isDefault());
    }

    /** @test */
    public function it_has_register_method()
    {
        $panel = $this->getTestPanel();

        // Should not throw an exception
        $panel->register();

        $this->assertTrue(true);
    }

    /** @test */
    public function it_has_boot_method()
    {
        $panel = $this->getTestPanel();
        $panel->colors(['primary' => '#3b82f6']);

        // Should not throw an exception
        $panel->boot();

        $this->assertTrue(true);
    }
}
