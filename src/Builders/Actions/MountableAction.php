<?php

namespace Streams\Ui\Builders\Actions;

use Streams\Ui\Exceptions;
use Streams\Ui\Builders\Concerns as Common;

class MountableAction extends Action
{
    use Common\BelongsToLivewire;
    use Concerns\CanOpenModal;
    use Concerns\CanRedirect;
    use Concerns\HasAction;
    use Concerns\HasForm;

    // use Concerns\CanBeMounted; // #configured like builders kinda
    // use Concerns\CanNotify;
    // use Concerns\CanSubmitForm;
    // use Concerns\CanRequireConfirmation;
    // use Concerns\HasInfolist;
    // use Concerns\HasLifecycleHooks;
    // use Concerns\HasWizard;

    public function call(array $parameters = []): mixed
    {
        return $this->evaluate($this->action, $parameters);
    }

    public function cancel(): void
    {
        throw new Exceptions\Cancel;
    }

    public function halt(): void
    {
        throw new Exceptions\Halt;
    }

    public function success(): void
    {
        // $this->sendSuccessNotification();
        // $this->dispatchSuccessRedirect();
    }

    public function failure(): void
    {
        // $this->sendFailureNotification();
        // $this->dispatchFailureRedirect();
    }

    protected function resolveDefaultClosureDependency(string $parameterName): array
    {
        return match ($parameterName) {
            // 'arguments' => [$this->getArguments()],
            // 'data' => [$this->getFormData()],
            'livewire' => [$this->getLivewire()],
            'entry' => [$this->getEntryInstance()],
            default => parent::resolveDefaultClosureDependency($parameterName),
        };
    }
}
