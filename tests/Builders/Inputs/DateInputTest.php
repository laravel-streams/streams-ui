<?php

namespace Streams\Ui\Tests\Builders\Inputs;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Inputs\Input;
use Streams\Ui\Builders\Inputs\DateInput;

class DateInputTest extends UiTestCase
{
    protected function getTestInput(): DateInput
    {
        return DateInput::make('date_field');
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $input = $this->getTestInput();

        $this->assertInstanceOf(Input::class, $input);
        $this->assertInstanceOf(DateInput::class, $input);
    }

    /** @test */
    public function it_has_default_view()
    {
        $input = $this->getTestInput();

        $this->assertEquals('ui::builders.inputs.date', $input->getView());
    }

    /** @test */
    public function it_can_set_and_get_placeholder()
    {
        $input = $this->getTestInput();

        $result = $input->placeholder('Select a date');

        $this->assertSame($input, $result);
        $this->assertEquals('Select a date', $input->getPlaceholder());
    }

    /** @test */
    public function it_can_set_min_date()
    {
        $input = $this->getTestInput();

        $result = $input->minDate('2024-01-01');

        $this->assertSame($input, $result);
        $this->assertEquals('2024-01-01', $input->getMinDate());
    }

    /** @test */
    public function it_can_set_max_date()
    {
        $input = $this->getTestInput();

        $result = $input->maxDate('2024-12-31');

        $this->assertSame($input, $result);
        $this->assertEquals('2024-12-31', $input->getMaxDate());
    }

    /** @test */
    public function it_evaluates_closure_min_date()
    {
        $input = $this->getTestInput();

        $input->minDate(fn () => '2024-06-01');

        $this->assertEquals('2024-06-01', $input->getMinDate());
    }

    /** @test */
    public function it_evaluates_closure_max_date()
    {
        $input = $this->getTestInput();

        $input->maxDate(fn () => '2024-06-30');

        $this->assertEquals('2024-06-30', $input->getMaxDate());
    }

    /** @test */
    public function it_can_set_step()
    {
        $input = $this->getTestInput();

        $result = $input->step(7);

        $this->assertSame($input, $result);
        $this->assertEquals(7, $input->getStep());
    }

    /** @test */
    public function it_can_set_datalist()
    {
        $input = $this->getTestInput();
        $dates = ['2024-01-01', '2024-06-01', '2024-12-31'];

        $result = $input->datalist($dates);

        $this->assertSame($input, $result);
        $this->assertEquals($dates, $input->getDatalist());
    }

    /** @test */
    public function it_can_set_autocomplete()
    {
        $input = $this->getTestInput();

        $result = $input->autocomplete('bday');

        $this->assertSame($input, $result);
        $this->assertEquals('bday', $input->getAutocomplete());
    }
}
