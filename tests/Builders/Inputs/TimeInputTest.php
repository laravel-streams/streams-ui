<?php

namespace Streams\Ui\Tests\Builders\Inputs;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Inputs\Input;
use Streams\Ui\Builders\Inputs\TimeInput;

class TimeInputTest extends UiTestCase
{
    protected function getTestInput(): TimeInput
    {
        return TimeInput::make('time_field');
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $input = $this->getTestInput();

        $this->assertInstanceOf(Input::class, $input);
        $this->assertInstanceOf(TimeInput::class, $input);
    }

    /** @test */
    public function it_has_default_view()
    {
        $input = $this->getTestInput();

        $this->assertEquals('ui::components.inputs.time', $input->getView());
    }

    /** @test */
    public function it_can_set_min_time()
    {
        $input = $this->getTestInput();

        $result = $input->minTime('09:00');

        $this->assertSame($input, $result);
        $this->assertEquals('09:00', $input->getMinTime());
    }

    /** @test */
    public function it_can_set_max_time()
    {
        $input = $this->getTestInput();

        $result = $input->maxTime('17:00');

        $this->assertSame($input, $result);
        $this->assertEquals('17:00', $input->getMaxTime());
    }

    /** @test */
    public function it_evaluates_closure_min_time()
    {
        $input = $this->getTestInput();

        $input->minTime(fn () => '08:00');

        $this->assertEquals('08:00', $input->getMinTime());
    }

    /** @test */
    public function it_evaluates_closure_max_time()
    {
        $input = $this->getTestInput();

        $input->maxTime(fn () => '18:00');

        $this->assertEquals('18:00', $input->getMaxTime());
    }
}
