<?php

namespace Streams\Ui\Inputs\Concerns;

use Illuminate\Support\Str;
use Streams\Ui\Inputs\Input;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Unique;

trait CanBeValidated
{
    protected array $rules = [];

    protected bool | \Closure $required = false;

    protected string | \Closure | null $regexPattern = null;

    protected string | \Closure | null $validationAttribute = null;

    public function currentPassword(bool | \Closure $condition = true): static
    {
        $this->rule('current_password', $condition);

        return $this;
    }
    
    public function activeUrl(bool | \Closure $condition = true): static
    {
        $this->rule('active_url', $condition);

        return $this;
    }

    public function alpha(bool | \Closure $condition = true): static
    {
        $this->rule('alpha', $condition);

        return $this;
    }

    public function alphaDash(bool | \Closure $condition = true): static
    {
        $this->rule('alpha_dash', $condition);

        return $this;
    }

    public function alphaNumeric(bool | \Closure $condition = true): static
    {
        $this->rule('alpha_num', $condition);

        return $this;
    }

    public function ascii(bool | \Closure $condition = true): static
    {
        $this->rule('ascii', $condition);

        return $this;
    }

    public function confirmed(bool | \Closure $condition = true): static
    {
        $this->rule('confirmed', $condition);

        return $this;
    }

    public function filled(bool | \Closure $condition = true): static
    {
        $this->rule('filled', $condition);

        return $this;
    }

    public function ip(bool | \Closure $condition = true): static
    {
        $this->rule('ip', $condition);

        return $this;
    }

    public function ipv4(bool | \Closure $condition = true): static
    {
        $this->rule('ipv4', $condition);

        return $this;
    }

    public function ipv6(bool | \Closure $condition = true): static
    {
        $this->rule('ipv6', $condition);

        return $this;
    }

    public function json(bool | \Closure $condition = true): static
    {
        $this->rule('json', $condition);

        return $this;
    }

    public function macAddress(bool | \Closure $condition = true): static
    {
        $this->rule('mac_address', $condition);

        return $this;
    }

    public function prohibited(bool | \Closure $condition = true): static
    {
        $this->rule('prohibited', $condition);

        return $this;
    }

    public function startsWith(array | string | \Closure $values): static
    {
        $this->rule(
            static function (Input $component) use ($values) {

                $values = $component->evaluate($values);

                if (is_array($values)) {
                    $values = implode(',', $values);
                }

                return 'starts_with:' . $values;
            },
            static function (Input $component) use ($values): bool {

                $values = $component->evaluate($values);

                return is_array($values) ? count($values) : filled($values);
            }
        );

        return $this;
    }

    public function doesntStartWith(array | string | \Closure $values): static
    {
        $this->rule(
            static function (Input $component) use ($values) {

                $values = $component->evaluate($values);

                if (is_array($values)) {
                    $values = implode(',', $values);
                }

                return 'doesnt_start_with:' . $values;
            },
            static function (Input $component) use ($values): bool {

                $values = $component->evaluate($values);

                return is_array($values) ? count($values) : filled($values);
            }
        );

        return $this;
    }

    public function endsWith(array | string | \Closure $values): static
    {
        $this->rule(
            static function (Input $component) use ($values) {

                $values = $component->evaluate($values);

                if (is_array($values)) {
                    $values = implode(',', $values);
                }

                return 'ends_with:' . $values;
            },
            static function (Input $component) use ($values): bool {

                $values = $component->evaluate($values);

                return is_array($values) ? count($values) : filled($values);
            }
        );

        return $this;
    }

    public function doesntEndWith(array | string | \Closure $values): static
    {
        $this->rule(
            static function (Input $component) use ($values) {

                $values = $component->evaluate($values);

                if (is_array($values)) {
                    $values = implode(',', $values);
                }

                return 'doesnt_end_with:' . $values;
            },
            static function (Input $component) use ($values): bool {

                $values = $component->evaluate($values);

                return is_array($values) ? count($values) : filled($values);
            }
        );

        return $this;
    }

    public function enum(string | \Closure $enum): static
    {
        $this->rule(
            static function (Input $component) use ($enum) {
                $enum = $component->evaluate($enum);

                return new Enum($enum);
            },
            static fn (
                Input $component
            ): bool => filled($component->evaluate($enum))
        );

        return $this;
    }

    public function exists(
        string | \Closure | null $table = null,
        string | \Closure | null $column = null,
        ?\Closure $modifyRuleUsing = null
    ): static {

        $this->rule(
            static function (
                Input $component,
                ?string $model
            ) use ($column, $modifyRuleUsing, $table) {

                $table = $component->evaluate($table) ?? $model;
                $column = $component->evaluate($column) ?? $component->getName();

                $rule = Rule::exists($table, $column);

                if ($modifyRuleUsing) {
                    $rule = $component->evaluate($modifyRuleUsing, [
                        'rule' => $rule,
                    ]) ?? $rule;
                }

                return $rule;
            },
            static fn (
                Input $component,
                ?string $model
            ): bool => (bool) ($component->evaluate($table) ?? $model)
        );

        return $this;
    }

    public function multipleOf(int | \Closure $value): static
    {
        $this->rule(
            static function (Input $component) use ($value) {
                return 'multiple_of:' . $component->evaluate($value);
            },
            static fn (
                Input $component
            ): bool => filled($component->evaluate($value))
        );

        return $this;
    }

    public function in(array | string | \Closure $values): static
    {
        $this->rule(
            static function (Input $component) use ($values) {

                $values = $component->evaluate($values);

                if (is_string($values)) {
                    $values = array_map('trim', explode(',', $values));
                }

                return Rule::in($values);
            },
            static function (Input $component) use ($values): bool {

                $values = $component->evaluate($values);

                return is_array($values) ? count($values) : filled($values);
            }
        );

        return $this;
    }

    public function notIn(array | string | \Closure $values): static
    {
        $this->rule(
            static function (Input $component) use ($values) {

                $values = $component->evaluate($values);

                if (is_string($values)) {
                    $values = array_map('trim', explode(',', $values));
                }

                return Rule::notIn($values);
            },
            static function (Input $component) use ($values): bool {

                $values = $component->evaluate($values);

                return is_array($values) ? count($values) : filled($values);
            }
        );

        return $this;
    }

    public function nullable(bool | \Closure $condition = true): static
    {
        $this->required(static function (Input $component) use ($condition): bool {
            return !$component->evaluate($condition);
        });

        return $this;
    }

    public function regex(string | \Closure | null $pattern): static
    {
        $this->regexPattern = $pattern;

        return $this;
    }

    public function notRegex(string | \Closure | null $pattern): static
    {
        $this->rule(
            static function (Input $component) use ($pattern) {
                return 'not_regex:' . $component->evaluate($pattern);
            },
            static fn (
                Input $component
            ): bool => filled($component->evaluate($pattern))
        );

        return $this;
    }

    public function required(bool | \Closure $condition = true): static
    {
        $this->required = $condition;

        return $this;
    }

    public function requiredIf(
        string | \Closure $statePath,
        mixed $stateValues,
        bool $absolute = false
    ): static {
        return $this->multiFieldValueComparisonRule(
            'required_if',
            $statePath,
            $stateValues,
            $absolute
        );
    }

    public function requiredUnless(
        string | \Closure $statePath,
        mixed $stateValues,
        bool $absolute = false
    ): static {
        return $this->multiFieldValueComparisonRule(
            'required_unless',
            $statePath,
            $stateValues,
            $absolute
        );
    }

    public function requiredWith(
        string | array | \Closure $statePaths,
        bool $absolute = false
    ): static {
        return $this->multiFieldComparisonRule(
            'required_with',
            $statePaths,
            $absolute
        );
    }

    public function requiredWithAll(
        string | array | \Closure $statePaths,
        bool $absolute = false
    ): static {
        return $this->multiFieldComparisonRule(
            'required_with_all',
            $statePaths,
            $absolute
        );
    }

    public function requiredWithout(
        string | array | \Closure $statePaths,
        bool $absolute = false
    ): static {
        return $this->multiFieldComparisonRule(
            'required_without',
            $statePaths,
            $absolute
        );
    }

    public function requiredWithoutAll(
        string | array | \Closure $statePaths,
        bool $absolute = false
    ): static {
        return $this->multiFieldComparisonRule(
            'required_without_all',
            $statePaths,
            $absolute
        );
    }

    public function string(bool | \Closure $condition = true): static
    {
        $this->rule('string', $condition);

        return $this;
    }

    public function uuid(bool | \Closure $condition = true): static
    {
        $this->rule('uuid', $condition);

        return $this;
    }

    public function rule(mixed $rule, bool | \Closure $condition = true): static
    {
        $this->rules = [
            ...$this->rules,
            [$rule, $condition],
        ];

        return $this;
    }

    public function rules(
        string | array $rules,
        bool | \Closure $condition = true
    ): static {

        if (is_string($rules)) {
            $rules = explode('|', $rules);
        }

        $this->rules = [
            ...$this->rules,
            ...array_map(static fn (string | object $rule): array => [$rule, $condition], $rules),
        ];

        return $this;
    }

    public function after(
        string | \Closure $date,
        bool $absolute = false
    ): static {
        return $this->dateComparisonRule('after', $date, $absolute);
    }

    public function afterOrEqual(
        string | \Closure $date,
        bool $absolute = false
    ): static {
        return $this->dateComparisonRule(
            'after_or_equal',
            $date,
            $absolute
        );
    }

    public function before(string | \Closure $date, bool $absolute = false): static
    {
        return $this->dateComparisonRule('before', $date, $absolute);
    }

    public function beforeOrEqual(string | \Closure $date, bool $absolute = false): static
    {
        return $this->dateComparisonRule('before_or_equal', $date, $absolute);
    }

    public function different(string | \Closure $statePath, bool $absolute = false): static
    {
        return $this->fieldComparisonRule('different', $statePath, $absolute);
    }

    public function gt(string | \Closure $statePath, bool $absolute = false): static
    {
        return $this->fieldComparisonRule('gt', $statePath, $absolute);
    }

    public function gte(string | \Closure $statePath, bool $absolute = false): static
    {
        return $this->fieldComparisonRule('gte', $statePath, $absolute);
    }

    public function lt(string | \Closure $statePath, bool $absolute = false): static
    {
        return $this->fieldComparisonRule('lt', $statePath, $absolute);
    }

    public function lte(string | \Closure $statePath, bool $absolute = false): static
    {
        return $this->fieldComparisonRule('lte', $statePath, $absolute);
    }

    public function same(string | \Closure $statePath, bool $absolute = false): static
    {
        return $this->fieldComparisonRule('same', $statePath, $absolute);
    }

    public function unique(
        string | \Closure | null $table = null,
        string | \Closure | null $column = null,
        Model | \Closure | null $ignorable = null,
        bool $ignoreRecord = false,
        ?\Closure $modifyRuleUsing = null
    ): static {

        $this->rule(
            static function (
                Input $component,
                ?string $model
            ) use (
                $column,
                $ignorable,
                $ignoreRecord,
                $modifyRuleUsing,
                $table
            ) {
                $table = $component->evaluate($table) ?? $model;
                $column = $component->evaluate($column) ?? $component->getName();

                $ignorable = ($ignoreRecord && !$ignorable) ?
                    $component->getRecord() :
                    $component->evaluate($ignorable);

                $rule = Rule::unique($table, $column)
                    ->when(
                        $ignorable,
                        fn (Unique $rule) => $rule->ignore(
                            $ignorable->getOriginal($ignorable->getKeyName()),
                            $ignorable->getQualifiedKeyName(),
                        ),
                    );

                if ($modifyRuleUsing) {
                    $rule = $component->evaluate($modifyRuleUsing, [
                        'rule' => $rule,
                    ]) ?? $rule;
                }

                return $rule;
            },
            fn (
                Input $component,
                ?string $model
            ): bool => (bool) ($component->evaluate($table) ?? $model)
        );

        return $this;
    }

    public function validationAttribute(string | \Closure | null $label): static
    {
        $this->validationAttribute = $label;

        return $this;
    }

    public function getRegexPattern(): ?string
    {
        return $this->evaluate($this->regexPattern);
    }

    public function getRequiredRule(): string
    {
        return $this->required() ? 'required' : 'nullable';
    }

    public function getValidationAttribute(): string
    {
        return $this->evaluate($this->validationAttribute) ?? Str::lcfirst($this->getLabel());
    }

    public function getValidationRules(): array
    {
        $rules = [
            $this->getRequiredRule(),
        ];

        if (filled($regexPattern = $this->getRegexPattern())) {
            $rules[] = "regex:{$regexPattern}";
        }

        foreach ($this->rules as [$rule, $condition]) {
            if (is_numeric($rule)) {
                $rules[] = $this->evaluate($condition);
            } elseif ($this->evaluate($condition)) {
                $rules[] = $this->evaluate($rule);
            }
        }

        return $rules;
    }

    public function dehydrateValidationRules(array &$rules): void
    {
        $statePath = $this->getStatePath();

        if (count($componentRules = $this->getValidationRules())) {
            $rules[$statePath] = $componentRules;
        }

        // if (!$this instanceof HasNestedRecursiveValidationRules) {
        //     return;
        // }

        $nestedRecursiveValidationRules = $this->getNestedRecursiveValidationRules();

        if (!count($nestedRecursiveValidationRules)) {
            return;
        }

        $rules["{$statePath}.*"] = $nestedRecursiveValidationRules;
    }

    public function dehydrateValidationAttributes(array &$attributes): void
    {
        $attributes[$this->getStatePath()] = $this->getValidationAttribute();
    }

    public function isRequired(): bool
    {
        return (bool) $this->evaluate($this->required);
    }

    public function dateComparisonRule(
        string $rule,
        string | \Closure $date,
        bool $absolute = false
    ): static {

        $this->rule(
            static function (
                Input $component
            ) use (
                $date,
                $absolute,
                $rule
            ): string {

                $date = $component->evaluate($date);

                if (!(strtotime($date) || $absolute)) {

                    $containerStatePath = $component->getContainer()->getStatePath();

                    if ($containerStatePath) {
                        $date = "{$containerStatePath}.{$date}";
                    }
                }

                return "{$rule}:{$date}";
            },
            fn (
                Input $component
            ): bool => (bool) $component->evaluate($date)
        );

        return $this;
    }

    public function fieldComparisonRule(
        string $rule,
        string | \Closure $statePath,
        bool $absolute = false
    ): static {

        $this->rule(
            static function (
                Input $component
            ) use (
                $absolute,
                $rule,
                $statePath
            ): string {

                $statePath = $component->evaluate($statePath);

                if (!$absolute) {

                    $containerStatePath = $component->getContainer()->getStatePath();

                    if ($containerStatePath) {
                        $statePath = "{$containerStatePath}.{$statePath}";
                    }
                }

                return "{$rule}:{$statePath}";
            },
            fn (
                Input $component
            ): bool => (bool) $component->evaluate($statePath)
        );

        return $this;
    }

    public function multiFieldComparisonRule(
        string $rule,
        array | string | \Closure $statePaths,
        bool $absolute = false
    ): static {

        $this->rule(
            static function (
                Input $component
            ) use (
                $absolute,
                $rule,
                $statePaths
            ): string {

                $statePaths = $component->evaluate($statePaths);

                if (!$absolute) {

                    if (is_string($statePaths)) {
                        $statePaths = explode(',', $statePaths);
                    }

                    $containerStatePath = $component->getContainer()->getStatePath();

                    if ($containerStatePath) {

                        $statePaths = array_map(
                            function ($statePath) use ($containerStatePath) {

                                $statePath = trim($statePath);

                                return "{$containerStatePath}.{$statePath}";
                            },
                            $statePaths
                        );
                    }
                }

                if (is_array($statePaths)) {
                    $statePaths = implode(',', $statePaths);
                }

                return "{$rule}:{$statePaths}";
            },
            fn (Input $component): bool => (bool) $component->evaluate($statePaths)
        );

        return $this;
    }

    public function multiFieldValueComparisonRule(
        string $rule,
        string | \Closure $statePath,
        mixed $stateValues,
        bool $absolute = false
    ): static {

        $this->rule(

            static function (
                Input $component
            ) use (
                $absolute,
                $rule,
                $statePath,
                $stateValues
            ): string {

                $statePath = $component->evaluate($statePath);
                $stateValues = $component->evaluate($stateValues);

                if (!$absolute) {

                    $containerStatePath = $component->getContainer()->getStatePath();

                    if ($containerStatePath) {
                        $statePath = "{$containerStatePath}.{$statePath}";
                    }
                }

                if (is_array($stateValues)) {
                    $stateValues = implode(',', $stateValues);
                }

                return "{$rule}:{$statePath},{$stateValues}";
            },
            fn (Input $component): bool => (bool) $component->evaluate($statePath)
        );

        return $this;
    }
}
