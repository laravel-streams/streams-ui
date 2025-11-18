<?php

namespace Streams\Ui\Tests\Builders\Inputs;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Inputs\Input;
use Streams\Ui\Builders\Inputs\TextInput;

class TextInputTest extends UiTestCase
{
    protected function getTestInput(): TextInput
    {
        return TextInput::make('text_field');
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $input = $this->getTestInput();

        $this->assertInstanceOf(Input::class, $input);
        $this->assertInstanceOf(TextInput::class, $input);
    }

    /** @test */
    public function it_has_default_view()
    {
        $input = $this->getTestInput();

        $this->assertEquals('ui::builders.inputs.text', $input->getView());
    }

    /** @test */
    public function it_has_default_text_type()
    {
        $input = $this->getTestInput();

        $this->assertEquals('text', $input->getType());
    }

    /** @test */
    public function it_can_be_email_type()
    {
        $input = $this->getTestInput();

        $result = $input->email();

        $this->assertSame($input, $result);
        $this->assertEquals('email', $input->getType());
        $this->assertTrue($input->isEmail());
    }

    /** @test */
    public function it_can_disable_email_type()
    {
        $input = $this->getTestInput();

        $input->email(false);

        $this->assertFalse($input->isEmail());
        $this->assertEquals('text', $input->getType());
    }

    /** @test */
    public function it_can_be_url_type()
    {
        $input = $this->getTestInput();

        $result = $input->url();

        $this->assertSame($input, $result);
        $this->assertEquals('url', $input->getType());
        $this->assertTrue($input->isUrl());
    }

    /** @test */
    public function it_can_be_tel_type()
    {
        $input = $this->getTestInput();

        $result = $input->tel();

        $this->assertSame($input, $result);
        $this->assertEquals('tel', $input->getType());
        $this->assertTrue($input->isTel());
    }

    /** @test */
    public function it_can_be_password_type()
    {
        $input = $this->getTestInput();

        $result = $input->password();

        $this->assertSame($input, $result);
        $this->assertEquals('password', $input->getType());
        $this->assertTrue($input->isPassword());
    }

    /** @test */
    public function it_can_be_numeric_type()
    {
        $input = $this->getTestInput();

        $result = $input->numeric();

        $this->assertSame($input, $result);
        $this->assertEquals('number', $input->getType());
        $this->assertTrue($input->isNumeric());
    }

    /** @test */
    public function it_can_be_integer_type()
    {
        $input = $this->getTestInput();

        $result = $input->integer();

        $this->assertSame($input, $result);
        $this->assertEquals('number', $input->getType());
        $this->assertTrue($input->isNumeric());
        $this->assertEquals(1, $input->getStep());
    }

    /** @test */
    public function it_can_set_and_get_placeholder()
    {
        $input = $this->getTestInput();

        $result = $input->placeholder('Enter text');

        $this->assertSame($input, $result);
        $this->assertEquals('Enter text', $input->getPlaceholder());
    }

    /** @test */
    public function it_evaluates_closure_placeholder()
    {
        $input = $this->getTestInput();

        $input->placeholder(fn () => 'Dynamic placeholder');

        $this->assertEquals('Dynamic placeholder', $input->getPlaceholder());
    }

    /** @test */
    public function it_can_set_and_get_prefix()
    {
        $input = $this->getTestInput();

        $result = $input->prefix('$');

        $this->assertSame($input, $result);
        $this->assertEquals('$', $input->getPrefix());
    }

    /** @test */
    public function it_evaluates_closure_prefix()
    {
        $input = $this->getTestInput();

        $input->prefix(fn () => '€');

        $this->assertEquals('€', $input->getPrefix());
    }

    /** @test */
    public function it_can_set_and_get_suffix()
    {
        $input = $this->getTestInput();

        $result = $input->suffix('USD');

        $this->assertSame($input, $result);
        $this->assertEquals('USD', $input->getSuffix());
    }

    /** @test */
    public function it_evaluates_closure_suffix()
    {
        $input = $this->getTestInput();

        $input->suffix(fn () => 'EUR');

        $this->assertEquals('EUR', $input->getSuffix());
    }

    /** @test */
    public function it_can_set_min_length()
    {
        $input = $this->getTestInput();

        $result = $input->minLength(5);

        $this->assertSame($input, $result);
        $this->assertEquals(5, $input->getMinLength());
    }

    /** @test */
    public function it_can_set_max_length()
    {
        $input = $this->getTestInput();

        $result = $input->maxLength(100);

        $this->assertSame($input, $result);
        $this->assertEquals(100, $input->getMaxLength());
    }

    /** @test */
    public function it_can_set_length_constraints()
    {
        $input = $this->getTestInput();

        $input->length(50);

        // length() sets both min and max to the same value
        $this->assertEquals(50, $input->getMinLength());
        $this->assertEquals(50, $input->getMaxLength());
    }

    /** @test */
    public function it_can_set_min_value()
    {
        $input = $this->getTestInput();

        $result = $input->minValue(0);

        $this->assertSame($input, $result);
        $this->assertEquals(0, $input->getMinValue());
    }

    /** @test */
    public function it_can_set_max_value()
    {
        $input = $this->getTestInput();

        $result = $input->maxValue(100);

        $this->assertSame($input, $result);
        $this->assertEquals(100, $input->getMaxValue());
    }

    /** @test */
    public function it_can_set_step()
    {
        $input = $this->getTestInput();

        $result = $input->step(0.01);

        $this->assertSame($input, $result);
        $this->assertEquals(0.01, $input->getStep());
    }

    /** @test */
    public function it_can_set_autocomplete()
    {
        $input = $this->getTestInput();

        $result = $input->autocomplete('email');

        $this->assertSame($input, $result);
        $this->assertEquals('email', $input->getAutocomplete());
    }

    /** @test */
    public function it_can_disable_autocomplete()
    {
        $input = $this->getTestInput();

        $input->autocomplete('off');

        $this->assertEquals('off', $input->getAutocomplete());
    }

    /** @test */
    public function it_can_set_datalist()
    {
        $input = $this->getTestInput();
        $options = ['Option 1', 'Option 2', 'Option 3'];

        $result = $input->datalist($options);

        $this->assertSame($input, $result);
        $this->assertEquals($options, $input->getDatalist());
    }

    /** @test */
    public function it_can_set_input_mode()
    {
        $input = $this->getTestInput();

        $result = $input->inputMode('numeric');

        $this->assertSame($input, $result);
        $this->assertEquals('numeric', $input->getInputMode());
    }

    /** @test */
    public function it_can_set_mask()
    {
        $input = $this->getTestInput();

        $result = $input->mask('999-999-9999');

        $this->assertSame($input, $result);
        $this->assertEquals('999-999-9999', $input->getMask());
    }

    /** @test */
    public function it_can_set_tel_regex()
    {
        $input = $this->getTestInput();
        $regex = '/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/';

        $result = $input->telRegex($regex);

        $this->assertSame($input, $result);
        $this->assertEquals($regex, $input->getTelRegex());
    }

    /** @test */
    public function it_has_default_tel_regex()
    {
        $input = $this->getTestInput();

        $this->assertEquals('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/', $input->getTelRegex());
    }

    /** @test */
    public function it_evaluates_closure_tel_regex()
    {
        $input = $this->getTestInput();

        $input->telRegex(fn () => '/custom-regex/');

        $this->assertEquals('/custom-regex/', $input->getTelRegex());
    }
}
