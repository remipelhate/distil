<?php

namespace Distil\Types;

use Distil\ActsAsCriteriaFactory;
use Distil\Criterion;
use Distil\Exceptions\InvalidCriterionValue;
use Distil\Values\ConstructsFromKeyword;

use function is_numeric;

abstract class IntegerCriterion implements Criterion
{
    use ActsAsCriteriaFactory;
    use ConstructsFromKeyword;

    private int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public static function fromString(string $value): self
    {
        if (! is_numeric($value)) {
            throw InvalidCriterionValue::expectedNumeric(static::class);
        }

        return new static((int) $value);
    }

    public function value(): int
    {
        return $this->value;
    }
}
