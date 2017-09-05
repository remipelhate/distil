<?php

namespace Distil\Types;

use Distil\Criterion;
use Distil\Keywords\Keyword;
use Distil\Keywords\Value;
use Distil\OneOffCriteria;

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
