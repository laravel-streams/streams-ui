<?php

namespace Streams\Ui\Tests\Colors;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Colors\Color;

class ColorTest extends UiTestCase
{
    /** @test */
    public function it_has_slate_color_palette()
    {
        $this->assertIsArray(Color::Slate);
        $this->assertArrayHasKey(50, Color::Slate);
        $this->assertArrayHasKey(500, Color::Slate);
        $this->assertArrayHasKey(950, Color::Slate);
        $this->assertCount(11, Color::Slate);
    }

    /** @test */
    public function it_has_gray_color_palette()
    {
        $this->assertIsArray(Color::Gray);
        $this->assertCount(11, Color::Gray);
    }

    /** @test */
    public function it_has_zinc_color_palette()
    {
        $this->assertIsArray(Color::Zinc);
        $this->assertCount(11, Color::Zinc);
    }

    /** @test */
    public function it_has_neutral_color_palette()
    {
        $this->assertIsArray(Color::Neutral);
        $this->assertCount(11, Color::Neutral);
    }

    /** @test */
    public function it_has_stone_color_palette()
    {
        $this->assertIsArray(Color::Stone);
        $this->assertCount(11, Color::Stone);
    }

    /** @test */
    public function it_has_red_color_palette()
    {
        $this->assertIsArray(Color::Red);
        $this->assertCount(11, Color::Red);
    }

    /** @test */
    public function it_has_orange_color_palette()
    {
        $this->assertIsArray(Color::Orange);
        $this->assertCount(11, Color::Orange);
    }

    /** @test */
    public function it_has_amber_color_palette()
    {
        $this->assertIsArray(Color::Amber);
        $this->assertCount(11, Color::Amber);
    }

    /** @test */
    public function it_has_yellow_color_palette()
    {
        $this->assertIsArray(Color::Yellow);
        $this->assertCount(11, Color::Yellow);
    }

    /** @test */
    public function it_has_lime_color_palette()
    {
        $this->assertIsArray(Color::Lime);
        $this->assertCount(11, Color::Lime);
    }

    /** @test */
    public function it_has_green_color_palette()
    {
        $this->assertIsArray(Color::Green);
        $this->assertCount(11, Color::Green);
    }

    /** @test */
    public function it_has_emerald_color_palette()
    {
        $this->assertIsArray(Color::Emerald);
        $this->assertCount(11, Color::Emerald);
    }

    /** @test */
    public function it_has_teal_color_palette()
    {
        $this->assertIsArray(Color::Teal);
        $this->assertCount(11, Color::Teal);
    }

    /** @test */
    public function it_has_cyan_color_palette()
    {
        $this->assertIsArray(Color::Cyan);
        $this->assertCount(11, Color::Cyan);
    }

    /** @test */
    public function it_has_sky_color_palette()
    {
        $this->assertIsArray(Color::Sky);
        $this->assertCount(11, Color::Sky);
    }

    /** @test */
    public function it_has_blue_color_palette()
    {
        $this->assertIsArray(Color::Blue);
        $this->assertCount(11, Color::Blue);
    }

    /** @test */
    public function it_has_indigo_color_palette()
    {
        $this->assertIsArray(Color::Indigo);
        $this->assertCount(11, Color::Indigo);
    }

    /** @test */
    public function it_has_violet_color_palette()
    {
        $this->assertIsArray(Color::Violet);
        $this->assertCount(11, Color::Violet);
    }

    /** @test */
    public function it_has_purple_color_palette()
    {
        $this->assertIsArray(Color::Purple);
        $this->assertCount(11, Color::Purple);
    }

    /** @test */
    public function it_has_fuchsia_color_palette()
    {
        $this->assertIsArray(Color::Fuchsia);
        $this->assertCount(11, Color::Fuchsia);
    }

    /** @test */
    public function it_has_pink_color_palette()
    {
        $this->assertIsArray(Color::Pink);
        $this->assertCount(11, Color::Pink);
    }

    /** @test */
    public function it_has_rose_color_palette()
    {
        $this->assertIsArray(Color::Rose);
        $this->assertCount(11, Color::Rose);
    }

    /** @test */
    public function it_color_values_are_rgb_strings()
    {
        $this->assertIsString(Color::Red[500]);
        $this->assertMatchesRegularExpression('/^\d+, \d+, \d+$/', Color::Red[500]);
    }

    /** @test */
    public function it_has_all_standard_shades()
    {
        $shades = [50, 100, 200, 300, 400, 500, 600, 700, 800, 900, 950];

        foreach ($shades as $shade) {
            $this->assertArrayHasKey($shade, Color::Red);
            $this->assertArrayHasKey($shade, Color::Blue);
            $this->assertArrayHasKey($shade, Color::Green);
        }
    }

    /** @test */
    public function it_can_generate_shades_from_hex()
    {
        $shades = Color::hex('#3B82F6');

        $this->assertIsArray($shades);
        $this->assertCount(11, $shades);
        $this->assertArrayHasKey(50, $shades);
        $this->assertArrayHasKey(500, $shades);
        $this->assertArrayHasKey(950, $shades);
    }

    /** @test */
    public function it_generates_rgb_format_from_hex()
    {
        $shades = Color::hex('#FF0000');

        $this->assertIsString($shades[500]);
        $this->assertMatchesRegularExpression('/^\d+, \d+, \d+$/', $shades[500]);
    }

    /** @test */
    public function it_can_generate_shades_from_rgb()
    {
        $shades = Color::rgb('rgb(59, 130, 246)');

        $this->assertIsArray($shades);
        $this->assertCount(11, $shades);
        $this->assertArrayHasKey(50, $shades);
        $this->assertArrayHasKey(500, $shades);
        $this->assertArrayHasKey(950, $shades);
    }

    /** @test */
    public function it_generates_lighter_shades_below_500()
    {
        $shades = Color::hex('#000000');

        // Shade 50 should be lighter (higher RGB values) than 500
        $shade50 = array_map('intval', explode(', ', $shades[50]));
        $shade500 = array_map('intval', explode(', ', $shades[500]));

        $this->assertGreaterThan($shade500[0], $shade50[0]);
    }

    /** @test */
    public function it_generates_darker_shades_above_500()
    {
        $shades = Color::hex('#FFFFFF');

        // Shade 950 should be darker (lower RGB values) than 500
        $shade950 = array_map('intval', explode(', ', $shades[950]));
        $shade500 = array_map('intval', explode(', ', $shades[500]));

        $this->assertLessThan($shade500[0], $shade950[0]);
    }

    /** @test */
    public function it_can_get_all_colors()
    {
        $all = Color::all();

        $this->assertIsArray($all);
        $this->assertArrayHasKey('slate', $all);
        $this->assertArrayHasKey('gray', $all);
        $this->assertArrayHasKey('red', $all);
        $this->assertArrayHasKey('blue', $all);
        $this->assertArrayHasKey('green', $all);
    }

    /** @test */
    public function it_all_returns_22_colors()
    {
        $all = Color::all();

        $this->assertCount(22, $all);
    }

    /** @test */
    public function it_all_colors_have_proper_structure()
    {
        $all = Color::all();

        foreach ($all as $name => $palette) {
            $this->assertIsArray($palette);
            $this->assertCount(11, $palette);
            $this->assertArrayHasKey(50, $palette);
            $this->assertArrayHasKey(500, $palette);
            $this->assertArrayHasKey(950, $palette);
        }
    }

    /** @test */
    public function it_all_uses_lowercase_keys()
    {
        $all = Color::all();

        foreach (array_keys($all) as $key) {
            $this->assertEquals(strtolower($key), $key);
        }
    }

    /** @test */
    public function it_hex_handles_short_hex_format()
    {
        $shades = Color::hex('#F00');

        $this->assertIsArray($shades);
        $this->assertCount(11, $shades);
    }

    /** @test */
    public function it_shade_500_represents_base_color()
    {
        $shades = Color::hex('#FF0000');

        // Shade 500 should be closest to the original red color
        $rgb = array_map('intval', explode(', ', $shades[500]));
        
        $this->assertEquals(255, $rgb[0]);
        $this->assertEquals(0, $rgb[1]);
        $this->assertEquals(0, $rgb[2]);
    }

    /** @test */
    public function it_generates_valid_rgb_values()
    {
        $shades = Color::hex('#3B82F6');

        foreach ($shades as $shade => $rgb) {
            $values = array_map('intval', explode(', ', $rgb));
            
            foreach ($values as $value) {
                $this->assertGreaterThanOrEqual(0, $value);
                $this->assertLessThanOrEqual(255, $value);
            }
        }
    }
}
