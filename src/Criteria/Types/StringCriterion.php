<?php

namespace BeatSwitch\Distil\Criteria\Types;

use BeatSwitch\Distil\Criteria\Criterion;
use BeatSwitch\Distil\Criteria\Keywords\Keyword;
use BeatSwitch\Distil\Criteria\Keywords\Value;
use BeatSwitch\Distil\Criteria\OneOffCriteria;

abstract class StringCriterion implements Criterion
{
    use OneOffCriteria;

    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        $this->value = (new Keyword(static::class, $value))->value();
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (new Value($this, $this->value))->keyword() ?: $this->value;
    }
}
