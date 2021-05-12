<?php

namespace Streams\Ui\Support\Traits;

use Streams\Core\Stream\Stream;
use Illuminate\Support\Facades\App;
use Streams\Core\Repository\Repository;

trait HasRepository
{

    public function repository()
    {
        if ($this->repository instanceof Repository) {
            return $this->repository;
        }

        /**
         * Default to configured.
         */
        if ($this->repository) {
            return $this->repository = App::make($this->repository, [
                'builder' => $this,
            ]);
        }

        /**
         * Fallback for Streams.
         */
        if (!$this->repository && $this->stream instanceof Stream) {
            return $this->repository = $this->stream->repository();
        }

        return null;
    }
}
