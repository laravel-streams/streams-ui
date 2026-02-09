<?php

namespace Streams\Ui\Builders\Actions;

use Streams\Ui\Builders\Concerns\HasActionCard;


class ActionCard extends Action
{
    ///var/www/development/Trabajo/GroupVitals/groupvitals.app.backend/vendor/streams/ui/src/Builders/Actions/ActionCard.php
    use HasActionCard;

    // Usaremos una ruta de vista que luego registraremos
    protected string $view = 'ui::builders.action-card';

    protected mixed $cardAction = null;
    protected string|null $actionName = null;

    /**
     * Establece la acción a ejecutar cuando se hace clic
     */
    public function action(mixed $action): static
    {
        $this->cardAction = $action;
        return $this;
    }

    public function getAction(): mixed
    {
        return $this->evaluate($this->cardAction);
    }

    /**
     * Establece el nombre de la acción (alternativa para modales)
     */
    public function actionName(string $name): static
    {
        $this->actionName = $name;
        return $this;
    }

    /**
     * Obtiene la acción configurada
     */
    public function getCardAction(): mixed
    {
        return $this->evaluate($this->cardAction);
    }

    /**
     * Obtiene el nombre de la acción
     */
    public function getActionName(): string|null
    {
        return $this->evaluate($this->actionName);
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Intentar pasarlo por el constructor de atributos
        $this->htmlAttributes([
            'class' => 'bg-white p-8 rounded-2xl border border-gray-200 shadow-sm hover:shadow-lg transition-all'
        ]);
    }
}
