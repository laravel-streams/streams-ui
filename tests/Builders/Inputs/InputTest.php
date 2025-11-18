<?php

namespace Streams\Ui\Tests\Builders\Inputs;

use Livewire\Component;
use Streams\Ui\Builders\Builder;
use Streams\Ui\Tests\UiTestCase;
use Illuminate\Contracts\View\View;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Inputs\Input;
use Streams\Ui\Builders\Inputs\TextInput;
use Illuminate\Contracts\Support\Htmlable;

class InputTest extends UiTestCase
{
    protected function getTestLivewireComponent(): Component
    {
        return new class extends Component
        {
            public string $name = '';

            public string $email = '';

            public function render()
            {
                return '';
            }
        };
    }

    protected function getTestInput(): Input
    {
        return TextInput::make('name')
            ->livewire($this->getTestLivewireComponent());
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $input = $this->getTestInput();

        $this->assertInstanceOf(Builder::class, $input);
        $this->assertInstanceOf(ViewBuilder::class, $input);
        $this->assertInstanceOf(Input::class, $input);
        $this->assertInstanceOf(Htmlable::class, $input);
    }

    /** @test */
    public function it_can_be_made_with_static_method()
    {
        $input = TextInput::make('email');

        $this->assertInstanceOf(Input::class, $input);
        $this->assertEquals('email', $input->getName());
    }

    /** @test */
    public function it_requires_name_on_construction()
    {
        $input = new TextInput('username');

        $this->assertEquals('username', $input->getName());
    }

    /** @test */
    public function it_sets_state_path_from_name()
    {
        $input = TextInput::make('email');

        $this->assertEquals('email', $input->getStatePath());
    }

    /** @test */
    public function it_has_view_identifier()
    {
        $input = $this->getTestInput();

        $view = $input->render();
        $data = $view->getData();

        $this->assertArrayHasKey('field', $data);
        $this->assertSame($input, $data['field']);
    }

    /** @test */
    public function it_can_set_and_get_label()
    {
        $input = $this->getTestInput();

        $result = $input->label('Full Name');

        $this->assertSame($input, $result);
        $this->assertEquals('Full Name', $input->getLabel());
    }

    /** @test */
    public function it_evaluates_closure_label()
    {
        $input = $this->getTestInput();

        $input->label(fn () => 'Dynamic Label');

        $this->assertEquals('Dynamic Label', $input->getLabel());
    }

    /** @test */
    public function it_can_set_and_get_help_text()
    {
        $input = $this->getTestInput();

        $result = $input->helpText('Enter your full name');

        $this->assertSame($input, $result);
        $this->assertEquals('Enter your full name', $input->getHelpText());
    }

    /** @test */
    public function it_evaluates_closure_help_text()
    {
        $input = $this->getTestInput();

        $input->helpText(fn () => 'Dynamic help');

        $this->assertEquals('Dynamic help', $input->getHelpText());
    }

    /** @test */
    public function it_can_be_autofocused()
    {
        $input = $this->getTestInput();

        $result = $input->autofocus();

        $this->assertSame($input, $result);
        $this->assertTrue($input->isAutofocused());
    }

    /** @test */
    public function it_can_disable_autofocus()
    {
        $input = $this->getTestInput();

        $input->autofocus(false);

        $this->assertFalse($input->isAutofocused());
    }

    /** @test */
    public function it_evaluates_closure_autofocus()
    {
        $input = $this->getTestInput();

        $input->autofocus(fn () => true);

        $this->assertTrue($input->isAutofocused());
    }

    /** @test */
    public function it_is_not_autofocused_by_default()
    {
        $input = $this->getTestInput();

        $this->assertFalse($input->isAutofocused());
    }

    /** @test */
    public function it_can_be_disabled()
    {
        $input = $this->getTestInput();

        $result = $input->disabled(true);

        $this->assertSame($input, $result);
        $this->assertTrue($input->isDisabled());
    }

    /** @test */
    public function it_can_conditionally_disable()
    {
        $input = $this->getTestInput();

        $input->disabled(fn () => true);

        $this->assertTrue($input->isDisabled());
    }

    /** @test */
    public function it_is_not_disabled_by_default()
    {
        $input = $this->getTestInput();

        $this->assertFalse($input->isDisabled());
    }

    /** @test */
    public function it_can_be_hidden()
    {
        $input = $this->getTestInput();

        $result = $input->hidden();

        $this->assertSame($input, $result);
        $this->assertTrue($input->isHidden());
    }

    /** @test */
    public function it_can_conditionally_hide()
    {
        $input = $this->getTestInput();

        $input->hidden(fn () => true);

        $this->assertTrue($input->isHidden());
    }

    /** @test */
    public function it_is_visible_by_default()
    {
        $input = $this->getTestInput();

        $this->assertFalse($input->isHidden());
    }

    /** @test */
    public function it_can_be_readonly()
    {
        $input = $this->getTestInput();

        $result = $input->readonly(true);

        $this->assertSame($input, $result);
        $this->assertTrue($input->isReadonly());
    }

    /** @test */
    public function it_evaluates_closure_readonly()
    {
        $input = $this->getTestInput();

        $input->readonly(fn () => true);

        $this->assertTrue($input->isReadonly());
    }

    /** @test */
    public function it_is_not_readonly_by_default()
    {
        $input = $this->getTestInput();

        $this->assertFalse($input->isReadonly());
    }

    /** @test */
    public function it_can_set_required()
    {
        $input = $this->getTestInput();

        $result = $input->required();

        $this->assertSame($input, $result);
        $this->assertTrue($input->isRequired());
    }

    /** @test */
    public function it_can_conditionally_require()
    {
        $input = $this->getTestInput();

        $input->required(fn () => true);

        $this->assertTrue($input->isRequired());
    }

    /** @test */
    public function it_is_not_required_by_default()
    {
        $input = $this->getTestInput();

        $this->assertFalse($input->isRequired());
    }

    /** @test */
    public function it_can_set_column_span()
    {
        $input = $this->getTestInput();

        $result = $input->columnSpan(2);

        $this->assertSame($input, $result);
        $columnSpan = $input->getColumnSpan();
        $this->assertEquals(2, $columnSpan['default']);
    }

    /** @test */
    public function it_can_set_full_width()
    {
        $input = $this->getTestInput();

        $result = $input->fullWidth();

        $this->assertSame($input, $result);
        $columnSpan = $input->getColumnSpan();
        $this->assertEquals('full', $columnSpan['default']);
    }

    /** @test */
    public function it_has_default_column_span()
    {
        $input = $this->getTestInput();

        $columnSpan = $input->getColumnSpan();
        $this->assertEquals(1, $columnSpan['default']);
    }

    /** @test */
    public function it_can_set_responsive_column_span()
    {
        $input = $this->getTestInput();

        $input->columnSpan(['default' => 1, 'md' => 2, 'lg' => 3]);

        $this->assertEquals(1, $input->getColumnSpan('default'));
        $this->assertEquals(2, $input->getColumnSpan('md'));
        $this->assertEquals(3, $input->getColumnSpan('lg'));
    }

    /** @test */
    public function it_can_set_default_state()
    {
        $this->markTestSkipped('Method conflicts with CanBeDefault trait - tested elsewhere');
    }

    /** @test */
    public function it_can_set_state_path()
    {
        $input = $this->getTestInput();

        $result = $input->statePath('user.name');

        $this->assertSame($input, $result);
        $this->assertEquals('user.name', $input->getStatePath());
    }

    /** @test */
    public function it_uses_state_path_as_id_when_no_id_set()
    {
        $input = TextInput::make('email');

        $this->assertEquals('email', $input->getId());
    }

    /** @test */
    public function it_can_override_id()
    {
        $input = TextInput::make('email');
        $input->id('custom-id');

        $this->assertEquals('custom-id', $input->getId());
    }

    /** @test */
    public function it_uses_state_path_as_key_when_no_key_set()
    {
        $input = TextInput::make('email');

        $this->assertEquals('email', $input->getKey());
    }

    /** @test */
    public function it_can_override_key()
    {
        $input = TextInput::make('email');
        $input->key('custom-key');

        $this->assertEquals('custom-key', $input->getKey());
    }

    /** @test */
    public function it_renders_to_view()
    {
        $input = $this->getTestInput();

        $view = $input->render();

        $this->assertInstanceOf(View::class, $view);
    }

    /** @test */
    public function it_can_set_html_attributes()
    {
        $input = $this->getTestInput();

        $input->htmlAttributes(['data-test' => 'value']);

        $attributes = $input->getHtmlAttributes();

        $this->assertArrayHasKey('data-test', $attributes);
        $this->assertEquals('value', $attributes['data-test']);
    }

    /** @test */
    public function it_belongs_to_livewire()
    {
        $livewire = $this->getTestLivewireComponent();
        $input = TextInput::make('name')->livewire($livewire);

        $this->assertSame($livewire, $input->getLivewire());
    }

    /** @test */
    public function it_can_have_parent()
    {
        $parent = TextInput::make('parent');
        $input = TextInput::make('child')->parent($parent);

        $this->assertSame($parent, $input->getParent());
    }
}
