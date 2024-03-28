<?php

namespace Streams\Ui\Colors;

use Spatie\Color\Hex;

class ColorManager
{
    protected array $colors = [];

    public function register(array $colors): static
    {
        foreach ($colors as $name => $color) {
            $this->colors[$name] = $this->processColor($color);
        }

        return $this;
    }

    public function processColor(array | string $color): array | string
    {
        if (is_string($color) && str_starts_with($color, '#')) {
            return Color::hex($color);
        }

        if (is_string($color) && str_starts_with($color, 'rgb')) {
            return Color::rgb($color);
        }

        if (is_array($color)) {
            return array_map(function (string $color): string {
                if (str_starts_with($color, '#')) {
                    $color = Hex::fromString($color)->toRgb();

                    return "{$color->red()}, {$color->green()}, {$color->blue()}";
                }

                if (str_starts_with($color, 'rgb')) {
                    return (string) str($color)
                        ->after('rgb(')
                        ->before(')');
                }

                return $color;
            }, $color);
        }

        return $color;
    }

    public function getColors(): array
    {
        return [
            'danger' => Color::Red,
            'gray' => Color::Zinc,
            'info' => Color::Blue,
            'primary' => Color::Amber,
            'success' => Color::Green,
            'warning' => Color::Amber,
            ...$this->colors,
        ];
    }
}
