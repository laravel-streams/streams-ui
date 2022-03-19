<?php

namespace Streams\Ui\Support\Javascript;

use Illuminate\Config\Repository;

class Config extends Repository
{
    public function mergeAt(string $path, array $value)
    {
        $data = $this->get($path, []);
        $data = array_replace_recursive($data, $value);
        $this->set($path, $data);
        return $this;
    }

    public function render()
    {
        return json_encode($this->all(), JSON_THROW_ON_ERROR);
    }
}
