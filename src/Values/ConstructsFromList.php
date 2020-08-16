<?php

declare(strict_types=1);

namespace Distil\Values;

use Distil\Exceptions\InvalidCriterionValue;

use function array_shift;
use function array_reduce;
use function gettype;

trait ConstructsFromList
{
    use ConstructsFromKeyword;

    private array $value;

    public function __construct(...$values)
    {
        $this->guardAgainstMixedTypes(...$values);

        $this->value = $values;
    }

    private function guardAgainstMixedTypes(...$values): void
    {
        $value = array_shift($values);

        array_reduce($values, [$this, 'compareValueTypes'], $value);
    }

    private function compareValueTypes($current, $next)
    {
        $currentType = gettype($current);
        $nextType = gettype($next);

        if ($currentType !== $nextType) {
            throw InvalidCriterionValue::mixedValueTypes($currentType, $nextType);
        }

        return $next;
    }
}
