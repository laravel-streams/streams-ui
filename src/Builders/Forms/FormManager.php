<?php

namespace Streams\Ui\Builders\Forms;

class FormManager
{
    protected array $forms = [];

    public function register(string $key, $form): void
    {
        $this->forms[$key] = $form;
    }

    public function resolve(string $key): ?Form
    {
        $form = $this->forms[$key] ?? null;

        if (is_callable($form) && ! ($form instanceof Form)) {
            $form = $form();

            if ($form instanceof Form) {
                $this->forms[$key] = $form;
            }
        }

        return $form instanceof Form ? $form : null;
    }

    public function all(): array
    {
        return $this->forms;
    }
}
