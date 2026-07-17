<?php

namespace Streams\Ui\Builders\Navigation;

class Vertical extends Navigation
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->style('vertical');
    }
}
