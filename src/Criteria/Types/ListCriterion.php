<?php

namespace BeatSwitch\Distil\Criteria\Types;

use BeatSwitch\Distil\Criteria\Criterion;
use BeatSwitch\Distil\Criteria\Exceptions\InvalidCriterionValue;
use BeatSwitch\Distil\Criteria\Keywords\Keyword;
use BeatSwitch\Distil\Criteria\Keywords\Value;
use BeatSwitch\Distil\Criteria\OneOffCriteria;

abstract class ListCriterion implements Criterion
{
    use OneOffCriteria;

    const DELIMITER = ',';

    /**
     * @var array
     */
    private $value;

    public function __construct(...$values)
    {
        $this->assertIdenticalValueTypes(...$values);

        $this->value = $values;
    }

    private function assertIdenticalValueTypes(...$values)
    {
        $value = array_shift($values);

        array_reduce($values, [$this, 'compareValueTypes'], $value);
    }

    private function compareValueTypes($currentValue, $nextValue)
    {
        if (gettype($currentValue) !== gettype($nextValue)) {
            throw InvalidCriterionValue::mixedValueTypes(gettype($currentValue), gettype($nextValue));
        }

        return $nextValue;
    }

    /**
     * @return static
     */
    public static function fromString(string $value): self
    {
        return new static(...self::stringValueToArray(
            (new Keyword(static::class, $value))->value()
        ));
    }

    protected static function stringValueToArray(string $value): array
    {
        return explode(static::DELIMITER, $value);
    }

    public function value(): array
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (new Value($this, $this->value))->keyword() ?: implode(static::DELIMITER, $this->value);
    }
}
