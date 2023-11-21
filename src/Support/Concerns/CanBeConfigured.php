<?php

namespace Streams\Ui\Support\Concerns;

trait CanBeConfigured
{
    protected static array $configurations = [];

    protected static array $deferredConfigurations = [];

    public static function configureUsing(
        \Closure $configuration,
        ?\Closure $during = null,
        bool $defer = false
    ): mixed {

        if ($defer) {
            static::$deferredConfigurations[static::class] ??= [];
            static::$deferredConfigurations[static::class][] = $configuration;
        } else {
            static::$configurations[static::class] ??= [];
            static::$configurations[static::class][] = $configuration;
        }

        if (!$during) {
            return null;
        }

        try {
            return $during();
        } finally {
            if ($defer) {
                array_pop(static::$deferredConfigurations[static::class]);
            } else {
                array_pop(static::$configurations[static::class]);
            }
        }
    }

    public function configure(): static
    {
        foreach (static::$configurations as $target => $configurations) {

            if (!$this instanceof $target) {
                continue;
            }

            foreach ($configurations as $configuration) {
                $configuration($this);
            }
        }

        $this->setUp();

        foreach (static::$deferredConfigurations as $target => $configurations) {

            if (!$this instanceof $target) {
                continue;
            }

            foreach ($configurations as $configuration) {
                $configuration($this);
            }
        }

        return $this;
    }

    protected function setUp(): void
    {
    }
}
