<?php

namespace Distil\Types;

use Distil\ActsAsCriteriaFactory;
use Distil\Criterion;
use Distil\Exceptions\InvalidCriterionValue;
use Distil\Keywords\Keyword;
use Distil\Keywords\Value;

abstract class IntegerCriterion implements Criterion
{
    use ActsAsCriteriaFactory;

    /**
     * @var int
     */
    private $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @return static
     */
    public static function fromString(string $value): self
    {
        $value = (new Keyword(static::class, $value))->value();

        if (! is_numeric($value)) {
            throw InvalidCriterionValue::expectedNumeric(static::class);
        }

        return new static((int) $value);
    }

    public function value(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (new Value($this, $this->value))->keyword() ?: (string) $this->value;
    }
}
