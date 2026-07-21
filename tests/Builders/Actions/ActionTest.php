<?php

namespace Streams\Ui\Tests\Builders\Actions;

use Streams\Ui\Builders\Builder;
use Streams\Ui\Tests\UiTestCase;
use Illuminate\Contracts\View\View;
use Streams\Ui\Builders\ViewBuilder;
use Illuminate\Support\Facades\Blade;
use Streams\Ui\Builders\Actions\Action;
use Streams\Ui\Builders\Actions\ActionMenu;
use Illuminate\Contracts\Support\Htmlable;

class ActionTest extends UiTestCase
{
    protected function getTestAction(): Action
    {
        return new Action('test-action');
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $action = $this->getTestAction();

        $this->assertInstanceOf(Builder::class, $action);
        $this->assertInstanceOf(ViewBuilder::class, $action);
        $this->assertInstanceOf(Action::class, $action);
        $this->assertInstanceOf(Htmlable::class, $action);
    }

    /** @test */
    public function it_can_be_made_with_static_method()
    {
        $action = Action::make('test-action');

        $this->assertInstanceOf(Action::class, $action);
        $this->assertEquals('test-action', $action->getName());
    }

    /** @test */
    public function it_sets_name_on_construction()
    {
        $action = new Action('my-action');

        $this->assertEquals('my-action', $action->getName());
    }

    /** @test */
    public function it_has_default_view()
    {
        $action = $this->getTestAction();

        $this->assertEquals('ui::action', $action->getView());
    }

    /** @test */
    public function it_has_view_identifier()
    {
        $action = $this->getTestAction();

        // The view identifier is used in the render method to expose the builder
        $view = $action->render();
        $data = $view->getData();

        $this->assertArrayHasKey('action', $data);
        $this->assertSame($action, $data['action']);
    }

    /** @test */
    public function it_can_set_and_get_tag()
    {
        $action = $this->getTestAction();

        $result = $action->tag('a');

        $this->assertSame($action, $result);
        $this->assertEquals('a', $action->getTag());
    }

    /** @test */
    public function it_has_default_button_tag()
    {
        $action = $this->getTestAction();

        $this->assertEquals('button', $action->getTag());
    }

    /** @test */
    public function it_evaluates_closure_tag()
    {
        $action = $this->getTestAction();

        $action->tag(fn () => 'span');

        $this->assertEquals('span', $action->getTag());
    }

    /** @test */
    public function it_can_set_and_get_style()
    {
        $action = $this->getTestAction();

        $result = $action->style('primary');

        $this->assertSame($action, $result);
        $this->assertEquals('primary', $action->getStyle());
    }

    /** @test */
    public function it_has_default_button_style()
    {
        $action = $this->getTestAction();

        $this->assertEquals('button', $action->getStyle());
    }

    /** @test */
    public function it_evaluates_closure_style()
    {
        $action = $this->getTestAction();

        $action->style(fn () => 'secondary');

        $this->assertEquals('secondary', $action->getStyle());
    }

    /** @test */
    public function it_can_set_action()
    {
        $action = $this->getTestAction();
        $closure = fn () => 'executed';

        $result = $action->action($closure);

        $this->assertSame($action, $result);
        $this->assertSame($closure, $action->getAction());
    }

    /** @test */
    public function it_returns_null_for_non_closure_action()
    {
        $action = $this->getTestAction();

        $action->action('string-action');

        $this->assertNull($action->getAction());
    }

    /** @test */
    public function it_can_call_action()
    {
        $action = $this->getTestAction();
        $executed = false;

        $action->action(function () use (&$executed) {
            $executed = true;

            return 'result';
        });

        $result = $action->call();

        $this->assertTrue($executed);
        $this->assertEquals('result', $result);
    }

    /** @test */
    public function it_can_call_action_with_payload()
    {
        $action = $this->getTestAction();

        $action->action(function ($value) {
            return $value;
        });

        $result = $action->call(['value' => 'test-value']);

        $this->assertEquals('test-value', $result);
    }

    /** @test */
    public function it_can_set_and_get_arguments()
    {
        $action = $this->getTestAction();
        $args = ['arg1' => 'value1', 'arg2' => 'value2'];

        $result = $action->arguments($args);

        $this->assertSame($action, $result);
        $this->assertEquals($args, $action->getArguments());
    }

    /** @test */
    public function it_can_reset_arguments()
    {
        $action = $this->getTestAction();

        $action->arguments(['arg1' => 'value1']);
        $action->resetArguments();

        $this->assertEquals([], $action->getArguments());
    }

    /** @test */
    public function it_can_set_and_get_tooltip()
    {
        $action = $this->getTestAction();

        $result = $action->tooltip('Click me');

        $this->assertSame($action, $result);
        $this->assertEquals('Click me', $action->getTooltip());
    }

    /** @test */
    public function it_evaluates_closure_tooltip()
    {
        $action = $this->getTestAction();

        $action->tooltip(fn () => 'Dynamic tooltip');

        $this->assertEquals('Dynamic tooltip', $action->getTooltip());
    }

    /** @test */
    public function it_can_set_and_get_key_bindings()
    {
        $action = $this->getTestAction();

        $result = $action->keyBindings(['ctrl+s']);

        $this->assertSame($action, $result);
        $this->assertEquals(['ctrl+s'], $action->getKeyBindings());
    }

    /** @test */
    public function it_wraps_string_key_binding_in_array()
    {
        $action = $this->getTestAction();

        $action->keyBindings('ctrl+s');

        $this->assertEquals(['ctrl+s'], $action->getKeyBindings());
    }

    /** @test */
    public function it_evaluates_closure_key_bindings()
    {
        $action = $this->getTestAction();

        $action->keyBindings(fn () => ['ctrl+k']);

        $this->assertEquals(['ctrl+k'], $action->getKeyBindings());
    }

    /** @test */
    public function it_returns_null_for_empty_key_bindings()
    {
        $action = $this->getTestAction();

        $action->keyBindings([]);

        $this->assertNull($action->getKeyBindings());
    }

    /** @test */
    public function it_can_set_and_get_border_radius()
    {
        $action = $this->getTestAction();

        $result = $action->borderRadius('lg');

        $this->assertSame($action, $result);
        $this->assertEquals('lg', $action->getBorderRadius());
    }

    /** @test */
    public function it_can_set_border_radius_as_bool()
    {
        $action = $this->getTestAction();

        $action->borderRadius(true);

        $this->assertTrue($action->getBorderRadius());
    }

    /** @test */
    public function it_evaluates_closure_border_radius()
    {
        $action = $this->getTestAction();

        $action->borderRadius(fn () => 'md');

        $this->assertEquals('md', $action->getBorderRadius());
    }

    /** @test */
    public function it_can_set_and_get_icon()
    {
        $action = $this->getTestAction();

        $result = $action->icon('heroicon-o-check');

        $this->assertSame($action, $result);
        $this->assertEquals('heroicon-o-check', $action->getIcon());
    }

    /** @test */
    public function it_evaluates_closure_icon()
    {
        $action = $this->getTestAction();

        $action->icon(fn () => 'heroicon-s-trash');

        $this->assertEquals('heroicon-s-trash', $action->getIcon());
    }

    /** @test */
    public function it_can_set_and_get_badge()
    {
        $action = $this->getTestAction();

        $result = $action->badge('5');

        $this->assertSame($action, $result);
        $this->assertEquals('5', $action->getBadge());
    }

    /** @test */
    public function it_can_set_badge_with_color()
    {
        $action = $this->getTestAction();

        $action->badge('10', 'danger');

        $this->assertEquals('10', $action->getBadge());
        $this->assertEquals('danger', $action->getBadgeColor());
    }

    /** @test */
    public function it_evaluates_closure_badge()
    {
        $action = $this->getTestAction();

        $action->badge(fn () => '3');

        $this->assertEquals('3', $action->getBadge());
    }

    /** @test */
    public function it_renders_badge()
    {
        $html = $this->getTestAction()
            ->badge('5', 'info')
            ->toHtml();

        $this->assertStringContainsString('min-w-[theme(spacing.4)]', $html);
        $this->assertMatchesRegularExpression('/>\s*5\s*</', $html);
    }

    /** @test */
    public function it_can_set_and_get_color()
    {
        $action = $this->getTestAction();

        $result = $action->color('primary');

        $this->assertSame($action, $result);
        $this->assertEquals('primary', $action->getColor());
    }

    /** @test */
    public function it_can_set_and_get_size()
    {
        $action = $this->getTestAction();

        $result = $action->size('lg');

        $this->assertSame($action, $result);
        $this->assertEquals('lg', $action->getSize());
    }

    /** @test */
    public function it_can_be_hidden()
    {
        $action = $this->getTestAction();

        $result = $action->hidden();

        $this->assertSame($action, $result);
        $this->assertTrue($action->isHidden());
        $this->assertFalse($action->isVisible());
    }

    /** @test */
    public function it_can_be_conditionally_hidden()
    {
        $action = $this->getTestAction();

        $action->hidden(fn () => true);

        $this->assertTrue($action->isHidden());
    }

    /** @test */
    public function it_is_visible_by_default()
    {
        $action = $this->getTestAction();

        $this->assertFalse($action->isHidden());
        $this->assertTrue($action->isVisible());
    }

    /** @test */
    public function it_can_be_disabled()
    {
        $action = $this->getTestAction();

        $result = $action->disabled(true);

        $this->assertSame($action, $result);
        $this->assertTrue($action->isDisabled());
    }

    /** @test */
    public function it_can_be_conditionally_disabled()
    {
        $action = $this->getTestAction();

        $action->disabled(fn () => true);

        $this->assertTrue($action->isDisabled());
    }

    /** @test */
    public function it_is_not_disabled_by_default()
    {
        $action = $this->getTestAction();

        $this->assertFalse($action->isDisabled());
    }

    /** @test */
    public function it_can_set_and_get_url()
    {
        $action = $this->getTestAction();

        $result = $action->url('/test-url');

        $this->assertSame($action, $result);
        $this->assertEquals('/test-url', $action->getUrl());
    }

    /** @test */
    public function it_evaluates_closure_url()
    {
        $action = $this->getTestAction();

        $action->url(fn () => '/dynamic-url');

        $this->assertEquals('/dynamic-url', $action->getUrl());
    }

    /** @test */
    public function it_can_set_url_to_open_in_new_tab()
    {
        $action = $this->getTestAction();

        $action->url('/test-url', true);

        $this->assertTrue($action->shouldOpenInNewTab());
    }

    /** @test */
    public function it_generates_label_from_name()
    {
        $action = new Action('save-record');

        $this->assertEquals('Save Record', $action->getLabel());
    }

    /** @test */
    public function it_generates_label_from_dotted_name()
    {
        $action = new Action('users.actions.edit');

        // The label is generated from the part after the last dot
        $this->assertEquals('Actions', $action->getLabel());
    }

    /** @test */
    public function it_can_override_generated_label()
    {
        $action = $this->getTestAction();

        $action->label('Custom Label');

        $this->assertEquals('Custom Label', $action->getLabel());
    }

    /** @test */
    public function it_evaluates_closure_label()
    {
        $action = $this->getTestAction();

        $action->label(fn () => 'Dynamic Label');

        $this->assertEquals('Dynamic Label', $action->getLabel());
    }

    /** @test */
    public function it_generates_label_when_label_is_null()
    {
        $action = Action::make('save-record')->label(null);

        $this->assertEquals('Save Record', $action->getLabel());
    }

    /** @test */
    public function it_hides_label_when_label_is_false()
    {
        $action = Action::make('save-record')->label(false);

        $this->assertFalse($action->getLabel());
    }

    /** @test */
    public function it_can_configure_as_link()
    {
        $action = $this->getTestAction();

        $result = $action->link('/test-url');

        $this->assertSame($action, $result);
        $this->assertEquals('a', $action->getTag());
        $this->assertEquals('link', $action->getStyle());
        $this->assertEquals('/test-url', $action->getUrl());
    }

    /** @test */
    public function it_can_configure_link_to_open_in_new_tab()
    {
        $action = $this->getTestAction();

        $action->link('/test-url', true);

        $this->assertEquals('a', $action->getTag());
        $this->assertTrue($action->shouldOpenInNewTab());
    }

    /** @test */
    public function it_can_configure_link_with_closure_url()
    {
        $action = $this->getTestAction();

        $action->link(fn () => '/dynamic-url');

        $this->assertEquals('a', $action->getTag());
        $this->assertEquals('/dynamic-url', $action->getUrl());
    }

    /** @test */
    public function it_renders_to_view()
    {
        $action = $this->getTestAction();

        $view = $action->render();

        $this->assertInstanceOf(View::class, $view);
    }

    /** @test */
    public function it_renders_with_action_data()
    {
        $action = $this->getTestAction();
        $action->icon('heroicon-o-check');
        $action->color('primary');

        $view = $action->render();
        $data = $view->getData();

        $this->assertArrayHasKey('action', $data);
        $this->assertSame($action, $data['action']);
    }

    /** @test */
    public function it_converts_to_html()
    {
        $action = $this->getTestAction();

        $html = $action->toHtml();

        $this->assertIsString($html);
    }

    /** @test */
    public function it_can_set_html_attributes()
    {
        $action = $this->getTestAction();

        $action->htmlAttributes(['data-test' => 'value', 'class' => 'btn']);

        $attributes = $action->getHtmlAttributes();

        $this->assertArrayHasKey('data-test', $attributes);
        $this->assertEquals('value', $attributes['data-test']);
    }

    /** @test */
    public function it_can_set_id()
    {
        $action = $this->getTestAction();

        $result = $action->id('test-id');

        $this->assertSame($action, $result);
        $this->assertEquals('test-id', $action->getId());
    }

    /** @test */
    public function it_evaluates_closure_id()
    {
        $action = $this->getTestAction();

        $action->id(fn () => 'dynamic-id');

        $this->assertEquals('dynamic-id', $action->getId());
    }

    /** @test */
    public function it_renders_view_with_label()
    {
        $action = Action::make('test-action')
            ->label('Click Here');

        $html = $action->toHtml();

        $this->assertStringContainsString('Click Here', $html);
    }

    /** @test */
    public function it_renders_view_with_generated_label()
    {
        $action = Action::make('save-record');

        $html = $action->toHtml();

        $this->assertStringContainsString('Save Record', $html);
    }

    /** @test */
    public function it_renders_button_by_default()
    {
        $action = Action::make('test-action')
            ->label('Submit');

        $html = $action->toHtml();

        $this->assertStringContainsString('Submit', $html);
        $this->assertStringContainsString('button', $html);
    }

    /** @test */
    public function it_renders_link_when_configured()
    {
        $action = Action::make('test-link')
            ->label('Visit Page')
            ->link('/test-url');

        $html = $action->toHtml();

        $this->assertStringContainsString('Visit Page', $html);
        $this->assertStringContainsString('/test-url', $html);
    }

    /** @test */
    public function it_renders_with_icon()
    {
        $action = Action::make('test-action')
            ->label('Save')
            ->icon('heroicon-o-check');

        $html = $action->toHtml();

        // Label should be present
        $this->assertStringContainsString('Save', $html);
        // Icon variable is passed to view (may not be fully rendered in test)
        $view = $action->render();
        $this->assertEquals('heroicon-o-check', $view->getData()['action']->getIcon());
    }

    /** @test */
    public function it_renders_with_color()
    {
        $action = Action::make('test-action')
            ->label('Delete')
            ->color('danger');

        $html = $action->toHtml();

        $this->assertStringContainsString('Delete', $html);
        $this->assertStringContainsString('danger', $html);
    }

    /** @test */
    public function it_renders_with_size()
    {
        $action = Action::make('test-action')
            ->label('Click')
            ->size('lg');

        $html = $action->toHtml();

        // Label should be present
        $this->assertStringContainsString('Click', $html);
        // Size is passed to view (may be transformed to classes)
        $view = $action->render();
        $this->assertEquals('lg', $view->getData()['action']->getSize());
    }

    /** @test */
    public function it_renders_with_tooltip()
    {
        $action = Action::make('test-action')
            ->label('Help')
            ->tooltip('Click for help');

        $html = $action->toHtml();

        // Label should be present
        $this->assertStringContainsString('Help', $html);
        // Tooltip is passed to view and rendered via Alpine.js
        $view = $action->render();
        $this->assertEquals('Click for help', $view->getData()['action']->getTooltip());
    }

    /** @test */
    public function it_renders_disabled_state()
    {
        $action = Action::make('test-action')
            ->label('Submit')
            ->disabled(true);

        $html = $action->toHtml();

        $this->assertStringContainsString('Submit', $html);
        $this->assertStringContainsString('disabled', $html);
    }

    /** @test */
    public function it_renders_with_custom_style()
    {
        $action = Action::make('test-action')
            ->label('Action')
            ->style('secondary');

        $html = $action->toHtml();

        $this->assertStringContainsString('Action', $html);
    }

    /** @test */
    public function it_renders_link_with_new_tab_target()
    {
        $action = Action::make('external-link')
            ->label('External')
            ->link('/external', true);

        $html = $action->toHtml();

        $this->assertStringContainsString('External', $html);
        $this->assertStringContainsString('_blank', $html);
    }

    /** @test */
    public function it_renders_with_html_attributes()
    {
        $action = Action::make('test-action')
            ->label('Custom')
            ->htmlAttributes(['data-custom' => 'value']);

        $html = $action->toHtml();

        // Label should be present and custom attribute in HTML
        $this->assertStringContainsString('Custom', $html);
        $this->assertStringContainsString('data-custom', $html);
        $this->assertStringContainsString('value', $html);
    }

    /** @test */
    public function it_renders_icon_only_action_with_square_padding()
    {
        $html = Blade::render(
            '<x-ui::action icon="heroicon-o-x-mark" color="black" borderRadius="full" class="ui-modal-close-btn" />'
        );

        preg_match('/class="([^"]+)"/', $html, $matches);
        $classes = $matches[1] ?? '';

        $this->assertStringContainsString('p-2', $classes);
        $this->assertStringNotContainsString('px-6', $classes);
        $this->assertStringNotContainsString('px-2', $classes);
        $this->assertStringNotContainsString('gap-1.5', $classes);
        $this->assertStringNotContainsString('gap-1', $classes);
        $this->assertStringNotContainsString('grid-flow-col', $classes);
        $this->assertStringContainsString('inline-flex', $classes);
        $this->assertStringContainsString('leading-none', $classes);
        $this->assertStringNotContainsString('inline-grid', $classes);
        $this->assertStringNotContainsString('flex items-center gap-', $html);
        $this->assertTrue($this->iconOnlyButtonStartsWithIcon($html));
    }

    /** @test */
    public function it_renders_false_label_action_without_label_gap_classes()
    {
        $html = Action::make('edit-record')
            ->label(false)
            ->icon('heroicon-o-pencil')
            ->toHtml();

        preg_match('/class="([^"]+)"/', $html, $matches);
        $classes = $matches[1] ?? '';

        $this->assertStringContainsString('p-2', $classes);
        $this->assertStringNotContainsString('px-6', $classes);
        $this->assertStringNotContainsString('gap-1.5', $classes);
        $this->assertStringNotContainsString('grid-flow-col', $classes);
        $this->assertStringContainsString('inline-flex', $classes);
        $this->assertStringNotContainsString('flex items-center gap-', $html);
    }

    /** @test */
    public function it_renders_whitespace_only_slot_without_label_gap_classes()
    {
        $html = Blade::render(
            '<x-ui::action icon="heroicon-o-pencil">   </x-ui::action>'
        );

        preg_match('/class="([^"]+)"/', $html, $matches);
        $classes = $matches[1] ?? '';

        $this->assertStringContainsString('p-2', $classes);
        $this->assertStringNotContainsString('px-6', $classes);
        $this->assertStringNotContainsString('gap-1.5', $classes);
        $this->assertStringContainsString('inline-flex', $classes);
        $this->assertStringNotContainsString('flex items-center gap-', $html);
    }

    /** @test */
    public function it_renders_icon_only_action_menu_trigger_without_label_gap_classes()
    {
        $html = ActionMenu::make('actions')
            ->label(false)
            ->icon('heroicon-o-ellipsis-vertical')
            ->color('secondary')
            ->actions([
                Action::make('edit')->label('Edit'),
            ])
            ->toHtml();

        preg_match('/class="([^"]*inline-flex[^"]*)"/', $html, $matches);

        $this->assertNotEmpty($matches[1] ?? null);
        $this->assertStringContainsString('p-2', $matches[1]);
        $this->assertStringNotContainsString('px-6', $matches[1]);
        $this->assertStringNotContainsString('gap-1.5', $matches[1]);
        $this->assertStringNotContainsString('grid-flow-col', $matches[1]);
        $this->assertStringContainsString('inline-flex', $matches[1]);
    }

    /** @test */
    public function it_renders_edit_group_type_pencil_without_left_side_label_space()
    {
        // Mirrors App\Domains\Groups\Panel\Actions\EditGroupTypeModal setUp().
        $html = Action::make('edit-group-type-modal')
            ->label(false)
            ->icon('heroicon-o-pencil')
            ->color('light')
            ->borderRadius('full')
            ->toHtml();

        preg_match('/class="([^"]+)"/', $html, $matches);
        $classes = $matches[1] ?? '';

        $this->assertStringContainsString('p-2', $classes);
        $this->assertStringContainsString('inline-flex', $classes);
        $this->assertStringContainsString('leading-none', $classes);
        $this->assertStringNotContainsString('px-6', $classes);
        $this->assertStringNotContainsString('gap-1.5', $classes);
        $this->assertStringNotContainsString('grid-flow-col', $classes);
        $this->assertStringNotContainsString('inline-grid', $classes);
        $this->assertStringNotContainsString('flex items-center gap-', $html);
        $this->assertStringNotContainsString('Edit Group Type Modal', $html);
        $this->assertTrue($this->iconOnlyButtonStartsWithIcon($html));
        $this->assertFalse($this->iconOnlyButtonStartsWithSpan($html));
    }

    /** @test */
    public function it_renders_empty_string_label_as_icon_only_without_left_space()
    {
        $html = Action::make('edit')
            ->label('')
            ->icon('heroicon-o-pencil')
            ->color('light')
            ->toHtml();

        preg_match('/class="([^"]+)"/', $html, $matches);
        $classes = $matches[1] ?? '';

        $this->assertStringContainsString('p-2', $classes);
        $this->assertStringNotContainsString('px-6', $classes);
        $this->assertStringNotContainsString('gap-1.5', $classes);
        $this->assertStringContainsString('inline-flex', $classes);
        $this->assertTrue($this->iconOnlyButtonStartsWithIcon($html));
    }

    /** @test */
    public function it_renders_labeled_action_with_wider_horizontal_padding()
    {
        $html = Blade::render(
            '<x-ui::action>Save</x-ui::action>'
        );

        $this->assertStringContainsString('py-2', $html);
        $this->assertStringContainsString('px-6', $html);
        $this->assertStringContainsString('gap-1.5', $html);
        $this->assertStringContainsString('inline-grid', $html);
        $this->assertStringContainsString('grid-flow-col', $html);
    }

    /** @test */
    public function it_renders_keyboard_focus_visible_ring_without_inaccessible_suppression()
    {
        $html = Action::make('add-group')
            ->label('Add Group')
            ->color('primary')
            ->toHtml();

        $this->assertStringContainsString('focus-visible:z-10', $html);
        $this->assertStringContainsString('focus-visible:ring-2', $html);
        $this->assertStringContainsString('focus-visible:ring-custom-500', $html);
        $this->assertStringContainsString('outline-none', $html);
        $this->assertStringNotContainsString('focus:ring-', $html);
        $this->assertStringNotContainsString('focus:outline-none', $html);
    }

    /** @test */
    public function it_renders_focus_visible_ring_for_link_actions()
    {
        $html = Action::make('view-details')
            ->label('View')
            ->link('/details')
            ->color('primary')
            ->toHtml();

        $this->assertStringContainsString('focus-visible:ring-2', $html);
        $this->assertStringContainsString('focus-visible:ring-custom-500', $html);
        $this->assertStringContainsString('outline-none', $html);
    }

    /** @test */
    public function it_renders_variant_specific_focus_visible_ring_for_black_actions()
    {
        $html = Blade::render(
            '<x-ui::action color="black">Black</x-ui::action>'
        );

        $this->assertStringContainsString('focus-visible:ring-2', $html);
        $this->assertStringContainsString('focus-visible:ring-gray-700', $html);
        $this->assertStringContainsString('outline-none', $html);
    }

    protected function iconOnlyButtonStartsWithIcon(string $html): bool
    {
        $button = $this->firstActionButton($html);

        if ($button === null) {
            return false;
        }

        foreach ($button->childNodes as $child) {
            if ($child->nodeType === XML_TEXT_NODE && trim($child->textContent) === '') {
                continue;
            }

            return $child->nodeType === XML_ELEMENT_NODE
                && in_array(strtolower($child->nodeName), ['svg', 'img', 'div'], true);
        }

        return false;
    }

    protected function iconOnlyButtonStartsWithSpan(string $html): bool
    {
        $button = $this->firstActionButton($html);

        if ($button === null) {
            return false;
        }

        foreach ($button->childNodes as $child) {
            if ($child->nodeType === XML_TEXT_NODE && trim($child->textContent) === '') {
                continue;
            }

            return $child->nodeType === XML_ELEMENT_NODE
                && strtolower($child->nodeName) === 'span';
        }

        return false;
    }

    protected function firstActionButton(string $html): ?\DOMElement
    {
        $dom = new \DOMDocument;
        @$dom->loadHTML('<?xml encoding="utf-8" ?>'.$html);

        foreach (['button', 'a'] as $tag) {
            $node = $dom->getElementsByTagName($tag)->item(0);

            if ($node instanceof \DOMElement) {
                return $node;
            }
        }

        return null;
    }
}
