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

    function colorVariables(string | array | null $color, array $shades): ?string
    {
        if ($color === null) {
            return null;
        }

        if (strpos($color, '-')) {
            
            $parts = explode('-', $color);

            $color = array_shift($parts);
            $shades[] = array_shift($parts);
        }

        // if ($alias !== null) {
        //     if (($overridingShades = FilamentColor::getOverridingShades($alias)) !== null) {
        //         $shades = $overridingShades;
        //     }

        //     if ($addedShades = FilamentColor::getAddedShades($alias)) {
        //         $shades = [...$shades, ...$addedShades];
        //     }

        //     if ($removedShades = FilamentColor::getRemovedShades($alias)) {
        //         $shades = array_diff($shades, $removedShades);
        //     }
        // }

        $variables = [];

        if (is_string($color)) {
            foreach ($shades as $shade) {
                $variables[] = "--c-{$shade}:var(--{$color}-{$shade})";
            }
        }

        if (is_array($color)) {
            foreach ($shades as $shade) {
                $variables[] = "--c-{$shade}:{$color[$shade]}";
            }
        }

        return implode(';', $variables);
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
