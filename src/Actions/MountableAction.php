<?php

namespace Streams\Ui\Actions;

use Streams\Ui\Exceptions;
use Streams\Ui\Traits as Common;
use Streams\Ui\Traits\BelongsToLivewire;

class MountableAction extends Action
{
    use BelongsToLivewire;

    use Traits\HasForm;
    use Traits\CanOpenModal;

    // use Concerns\CanBeMounted;
    // use Concerns\CanRedirect;
    //use Concerns\CanNotify;
    //use Concerns\CanRequireConfirmation;
    //use Concerns\HasInfolist;
    //use Concerns\HasLifecycleHooks;
    //use Concerns\HasParentActions;
    //use Concerns\HasWizard;

    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultView('ui::builders.action');

        //$this->failureNotification(fn (Notification $notification): Notification => $notification);
        //$this->successNotification(fn (Notification $notification): Notification => $notification);
    }

    public function call(array $parameters = []): mixed
    {
        return $this->evaluate($this->action, $parameters);
    }

    public function cancel(): void
    {
        throw new Exceptions\Cancel();
    }

    public function halt(): void
    {
        throw new Exceptions\Halt();
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

    protected function resolveDefaultClosureDependencyForEvaluationByName(string $parameterName): array
    {
        return match ($parameterName) {
            // 'arguments' => [$this->getArguments()],
            // 'data' => [$this->getFormData()],
            'livewire' => [$this->getLivewire()],
            default => parent::resolveDefaultClosureDependencyForEvaluationByName($parameterName),
        };
    }
}
