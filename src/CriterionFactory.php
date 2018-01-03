<?php

namespace Distil;

use Distil\Exceptions\CannotCreateCriterion;
use InvalidArgumentException;

final class CriterionFactory
{
    /**
     * @var array
     */
    private $criteriaResolvers;

    public function __construct(array $criteriaResolvers = [])
    {
        foreach ($criteriaResolvers as $resolver) {
            if (! $this->isValidResolver($resolver)) {
                throw new InvalidArgumentException('Resolvers should either be callable or a class name.');
            }
        }

        $this->criteriaResolvers = $criteriaResolvers;
    }

    private function isValidResolver($resolver): bool
    {
        return is_callable($resolver) || class_exists($resolver);
    }

    public function createByName(string $name, ...$arguments): Criterion
    {
        $criterion = $this->resolver($name);

        if (is_callable($criterion)) {
            return call_user_func_array($criterion, $arguments);
        }

        return new $criterion(...$arguments);
    }

    private function resolver(string $name)
    {
        if (! array_key_exists($name, $this->criteriaResolvers)) {
            throw CannotCreateCriterion::missingResolver($name, array_keys($this->criteriaResolvers));
        }

        return $this->criteriaResolvers[$name];
    }
}
