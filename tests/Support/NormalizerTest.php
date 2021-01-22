<?php

namespace Streams\Ui\Tests\Support;

use Tests\TestCase;
use Streams\Ui\Support\Component;
use Illuminate\Support\Collection;
use Streams\Ui\Support\Normalizer;
use Illuminate\Support\Facades\URL;

class NormalizerTest extends TestCase
{

    // public function setUp(): void
    // {
    //     $this->createApplication();

    //     Streams::load(base_path('vendor/streams/ui/tests/examples.json'));
    // }

    public function testNormalize()
    {
        $output = Normalizer::normalize(['test']);

        $this->assertEquals(
            [
                [
                    'handle' => 'test',
                ]
            ],
            $output
        );

        $output = Normalizer::normalize(['test'], 'id');

        $this->assertEquals(
            [
                [
                    'id' => 'test',
                ]
            ],
            $output
        );
    }

    public function testFillWithKey()
    {
        $output = Normalizer::fillWithKey(['test' => ['type' => 'example']], 'handle');

        $this->assertEquals(
            [
                'test' => [
                    'handle' => 'test',
                    'type' => 'example',
                ]
            ],
            $output
        );
    }

    public function testFillWithAttribute()
    {
        $output = Normalizer::fillWithAttribute(['test' => ['type' => 'example']], 'handle', 'type');

        $this->assertEquals(
            [
                'test' => [
                    'handle' => 'example',
                    'type' => 'example',
                ]
            ],
            $output
        );
    }

    public function testFillWithValue()
    {
        $output = Normalizer::fillWithValue(['test' => ['type' => 'example']], 'handle', 'foo');

        $this->assertEquals(
            [
                'test' => [
                    'handle' => 'foo',
                    'type' => 'example',
                ]
            ],
            $output
        );
    }
}
