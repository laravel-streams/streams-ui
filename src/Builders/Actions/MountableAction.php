<?php

namespace Streams\Ui\Builders\Actions;

use Streams\Ui\Builders\Concerns\BelongsToLivewire;
use Streams\Ui\Builders\ViewBuilder;

class MountableAction extends ViewBuilder
{
    use BelongsToLivewire;

    use Concerns\CanBeMounted;
    use Concerns\CanRedirect;
    //use Concerns\CanNotify;
    //use Concerns\CanOpenModal;
    //use Concerns\CanRequireConfirmation;
    //use Concerns\HasForm;
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

    /**
     * @param  array<string, mixed>  $parameters
     */
    public function call(array $parameters = []): mixed
    {
        return $this->evaluate($this->getActionFunction(), $parameters);
    }

    public function cancel(): void
    {
        // throw new Cancel();
        throw new \Exception();
    }

    public function halt(): void
    {
        // throw new Halt();
        throw new \Exception();
    }

    public function success(): void
    {
        // $this->sendSuccessNotification();
        $this->dispatchSuccessRedirect();
    }

    public function failure(): void
    {
        // $this->sendFailureNotification();
        $this->dispatchFailureRedirect();
    }

    /**
     * @return array<mixed>
     */
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
