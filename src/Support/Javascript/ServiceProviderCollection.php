<?php

namespace Streams\Ui\Support\Javascript;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ServiceProviderCollection extends Collection
{
    public function set($id, $provider)
    {
        $this->items[ $id ] = $provider;
        return $this;
    }

    /**
     * @return string
     * @throws \JsonException
     */
    public function render()
    {
        $providers = $this
            ->values()
            ->map(function ($provider) {
                if ( ! Str::startsWith('window', $provider)) {
                    $provider = 'window.' . $provider;
                }
                return $provider;
            })
            ->toArray();
        $json = json_encode($providers, JSON_THROW_ON_ERROR);
        return str_replace('"','',$json);
    }
}
