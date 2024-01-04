<?php

namespace Streams\Ui\Traits;

use Illuminate\Contracts\Container\BindingResolutionException;

trait EvaluatesClosures
{
    protected string $evaluationIdentifier;

    public function evaluate(
        mixed $value,
        array $namedInjections = [],
        array $typedInjections = []
    ) {

        if (!$value instanceof \Closure) {
            return $value;
        }

        $dependencies = [];

        foreach ((new \ReflectionFunction($value))->getParameters() as $parameter) {

            $dependencies[] = $this->resolveClosureDependencies(
                $parameter,
                $namedInjections,
                $typedInjections
            );
        }

        return $value(...$dependencies);
    }

    protected function resolveClosureDependencies(
        \ReflectionParameter $parameter,
        array $namedInjections,
        array $typedInjections
    ): mixed {

        $parameterName = $parameter->getName();

        if (array_key_exists($parameterName, $namedInjections)) {
            return value($namedInjections[$parameterName]);
        }

        //$typedParameterClassName = $this->getTypedReflectionParameterClassName($parameter);

        // if (
        //     filled($typedParameterClassName)
        //     && array_key_exists($typedParameterClassName, $typedInjections)
        // ) {
        //     return value($typedInjections[$typedParameterClassName]);
        // }

        // Dependencies are wrapped in an array to differentiate between null and no value.
        $dependencyByName = $this->resolveDefaultClosureDependency($parameterName);

        if (count($dependencyByName)) {
            // Unwrap the dependency if it was resolved.
            return $dependencyByName[0];
        }

        // if (filled($typedParameterClassName)) {
        //     // Dependencies are wrapped in an array to differentiate between null and no value.
        //     $defaultWrappedDependencyByType = $this->resolveDefaultClosureDependencyForEvaluationByType($typedParameterClassName);

        //     if (count($defaultWrappedDependencyByType)) {
        //         // Unwrap the dependency if it was resolved.
        //         return $defaultWrappedDependencyByType[0];
        //     }
        // }

        if (
            isset($this->evaluationIdentifier)
            && $parameterName === $this->evaluationIdentifier
        ) {
            return $this;
        }

        // if (filled($typedParameterClassName)) {
        //     return app()->make($typedParameterClassName);
        // }

        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        if ($parameter->isOptional()) {
            return null;
        }

        $staticClass = static::class;

        throw new BindingResolutionException("Unable to resolve parameter [\${$parameterName}] for closure in [{$staticClass}].");
    }

    protected function getTypedReflectionParameterClassName(\ReflectionParameter $parameter): ?string
    {
        $type = $parameter->getType();

        if (!$type instanceof \ReflectionNamedType) {
            return null;
        }

        if ($type->isBuiltin()) {
            return null;
        }

        $name = $type->getName();

        $class = $parameter->getDeclaringClass();

        if (blank($class)) {
            return $name;
        }

        if ($name === 'self') {
            return $class->getName();
        }

        if ($name === 'parent' && ($parent = $class->getParentClass())) {
            return $parent->getName();
        }

        return $name;
    }

    protected function resolveDefaultClosureDependencyForEvaluationByName(string $parameterName): array
    {
        return [];
    }

    protected function resolveDefaultClosureDependencyForEvaluationByType(string $parameterName): array
    {
        return [];
    }

    protected function resolveDefaultClosureDependency(string $parameterName): array
    {
        return [];
    }
}
