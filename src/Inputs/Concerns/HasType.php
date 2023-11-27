<?php

namespace Streams\Ui\Inputs\Concerns;

use Streams\Ui\Inputs\TextInput;

trait HasType
{
    protected bool | \Closure $tel = false;
    protected bool | \Closure $url = false;
    protected bool | \Closure $email = false;
    protected bool | \Closure $numeric = false;
    protected bool | \Closure $password = false;

    protected ?string $type = null;

    public function getType(): string
    {
        if ($this->type) {
            return $this->type;
        }

        if ($this->isEmail()) {
            return $this->type = 'email';
        } elseif ($this->isNumeric()) {
            return $this->type = 'number';
        } elseif ($this->isPassword()) {
            return $this->type = 'password';
        } elseif ($this->isTel()) {
            return $this->type = 'tel';
        } elseif ($this->isUrl()) {
            return $this->type = 'url';
        }

        return $this->type = 'text';
    }

    public function url(bool | \Closure $condition = true): static
    {
        $this->url = $condition;

        $this->rule('url', $condition);

        return $this;
    }

    public function email(bool | \Closure $condition = true): static
    {
        $this->email = $condition;

        $this->rule('email', $condition);

        return $this;
    }

    public function password(bool | \Closure $condition = true): static
    {
        $this->password = $condition;

        return $this;
    }

    public function integer(bool | \Closure $condition = true): static
    {
        $this->numeric($condition);
        $this->inputMode(static fn (): ?string => $condition ? 'numeric' : null);
        $this->step(static fn (): ?int => $condition ? 1 : null);

        return $this;
    }

    public function numeric(bool | \Closure $condition = true): static
    {
        $this->numeric = $condition;

        $this->inputMode(static fn (): ?string => $condition ? 'decimal' : null);
        $this->rule('numeric', $condition);
        $this->step(static fn (): ?string => $condition ? 'any' : null);

        return $this;
    }

    public function tel(bool | \Closure $condition = true): static
    {
        $this->tel = $condition;

        $this->regex(static fn (
            TextInput $component
        ) => $component->evaluate($condition) ? $component->getTelRegex() : null);

        return $this;
    }

    public function isEmail(): bool
    {
        return (bool) $this->evaluate($this->email);
    }

    public function isNumeric(): bool
    {
        return (bool) $this->evaluate($this->numeric);
    }

    public function isPassword(): bool
    {
        return (bool) $this->evaluate($this->password);
    }

    public function isTel(): bool
    {
        return (bool) $this->evaluate($this->tel);
    }

    public function isUrl(): bool
    {
        return (bool) $this->evaluate($this->url);
    }
}
