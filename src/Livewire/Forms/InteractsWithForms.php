<?php

namespace Streams\Ui\Livewire\Forms;

use Streams\Ui\Builders\Forms\Form;
use Streams\Ui\Support\Facades\Forms;
use Streams\Ui\Notifications\Notification;

/**
 * Registers/caches forms and dispatches {@see handleForm()} to the resolved {@see Form}.
 *
 * Hydration uses {@see Form} + {@see \Streams\Ui\Builders\Concerns\HasState} ({@see Form::fill()}).
 * When reading values for submit/DTOs, prefer {@see HasState::getState()} (validated); use {@see HasState::getRawState()}
 * only when skipping validation is intentional.
 * {@see \Streams\Ui\Builders\Actions\Concerns\HasForm::getFormData()} is separate: mounted actions receive payload via action wiring.
 */
trait InteractsWithForms
{
    protected ?array $cachedForms = null;

    public function cacheForms(): array
    {
        $this->cachedForms = [];

        $registered = Forms::all();

        $forms = $this->getForms();

        foreach ($forms + $registered as $form) {

            if ($form instanceof \Closure) {
                $form = $form();
            }

            if (! $form instanceof Form) {
                continue;
            }

            $form->livewire($this);

            $this->cachedForms[$form->getName()] = $form;
        }

        return $this->cachedForms;
    }

    /**
     * @return array<string, Form|\Closure>
     */
    protected function getForms(): array
    {
        return [];
    }

    public function getCachedForms(): array
    {
        if ($this->cachedForms === null) {
            $this->cachedForms = $this->cacheForms();
        }

        return $this->cachedForms;
    }

    public function getForm(?string $name = null): Form
    {
        $name = $this->resolveFormName($name);
        $cachedForms = $this->getCachedForms();

        $form = $cachedForms[$name] ?? null;

        if (! $form) {
            throw new \InvalidArgumentException(
                'No form named ['.$name.'] found in the Livewire component ['.get_class($this).'].'
            );
        }

        return $form;
    }

    public function handleForm(?string $name = null, string $method = 'handle', array $payload = []): mixed
    {
        $form = $this->getForm($name);

        $form->livewire($this);

        if (! method_exists($form, $method)) {
            throw new \InvalidArgumentException(
                "Form [{$name}] does not define method [{$method}] on [".get_class($form).'].'
            );
        }

        try {
            return $form->{$method}($payload);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            throw $exception;
        } catch (\Throwable $exception) {
            Notification::make()
                ->title('Error')
                ->description($exception->getMessage())
                ->danger()
                ->push($this);

            return null;
        }
    }

    protected function resolveFormName(?string $name): string
    {
        if (is_string($name) && $name !== '') {
            return $name;
        }

        $cachedForms = $this->getCachedForms();

        if (isset($cachedForms['default'])) {
            return 'default';
        }

        if (count($cachedForms) === 1) {
            return (string) array_key_first($cachedForms);
        }

        return 'default';
    }
}
