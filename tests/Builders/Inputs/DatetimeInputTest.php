<?php

namespace Streams\Ui\Tests\Builders\Inputs;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Inputs\Input;
use Streams\Ui\Builders\Inputs\DatetimeInput;

class DatetimeInputTest extends UiTestCase
{
    protected function getTestInput(): DatetimeInput
    {
        return DatetimeInput::make('datetime_field');
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $input = $this->getTestInput();

        $this->assertInstanceOf(Input::class, $input);
        $this->assertInstanceOf(DatetimeInput::class, $input);
    }

    /** @test */
    public function it_has_default_view()
    {
        $input = $this->getTestInput();

        $this->assertEquals('ui::builders.inputs.datetime', $input->getView());
    }

    /** @test */
    public function it_can_set_and_get_placeholder()
    {
        $input = $this->getTestInput();

        $result = $input->placeholder('Select date and time');

        $this->assertSame($input, $result);
        $this->assertEquals('Select date and time', $input->getPlaceholder());
    }

    /** @test */
    public function it_can_set_min_date()
    {
        $input = $this->getTestInput();

        $result = $input->minDate('2024-01-01T00:00');

        $this->assertSame($input, $result);
        $this->assertEquals('2024-01-01T00:00', $input->getMinDate());
    }

    /** @test */
    public function it_can_set_max_date()
    {
        $input = $this->getTestInput();

        $result = $input->maxDate('2024-12-31T23:59');

        $this->assertSame($input, $result);
        $this->assertEquals('2024-12-31T23:59', $input->getMaxDate());
    }

    /** @test */
    public function it_can_set_step()
    {
        $input = $this->getTestInput();

        $result = $input->step(60);

        $this->assertSame($input, $result);
        $this->assertEquals(60, $input->getStep());
    }

    /** @test */
    public function it_can_set_datalist()
    {
        $input = $this->getTestInput();
        $datetimes = ['2024-01-01T09:00', '2024-01-01T14:00', '2024-01-01T18:00'];

        $result = $input->datalist($datetimes);

        $this->assertSame($input, $result);
        $this->assertEquals($datetimes, $input->getDatalist());
    }
}
