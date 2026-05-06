<?php

namespace Streams\Ui\Builders\Actions;

use Livewire\Component;
use Streams\Ui\Exceptions;

class MountableAction extends Action
{
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

    public static function for(Component $livewire, ?string $name = null): static
    {
        $resolvedName = $name ?? static::getDefaultName();

        $static = new static($resolvedName);

        $static->livewire($livewire);
        $static->configure();

        return $static;
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
