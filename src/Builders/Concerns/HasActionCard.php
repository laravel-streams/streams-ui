<?php

namespace Streams\Ui\Builders\Concerns;

trait HasActionCard
{
    ///var/www/development/Trabajo/GroupVitals/groupvitals.app.backend/vendor/streams/ui/src/Builders/Concerns/HasActionCard.php
    public string|null $description = null;

    public function description(string|null $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): string|null
    {
        return $this->evaluate($this->description);
    }
}
