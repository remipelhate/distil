<?php

namespace Distil;

use Distil\Exceptions\CannotCreateCriterion;

final class CriterionFactory
{
    /**
     * @var array
     */
    private $criteriaResolvers;

    public function __construct(array $criteriaResolvers = [])
    {
        $this->criteriaResolvers = $criteriaResolvers;
    }

    public function createByName(string $name, ...$arguments): Criterion
    {
        $criterion = $this->resolver($name);

        if (is_callable($criterion)) {
            return call_user_func_array($criterion, $arguments);
        }

        return new $criterion(...$arguments);
    }

    private function resolver(string $name): string
    {
        if (array_key_exists($name, $this->criteriaResolvers)) {
            return $this->criteriaResolvers[$name];
        }

        throw CannotCreateCriterion::missingResolver($name, array_keys($this->criteriaResolvers));
    }
}
