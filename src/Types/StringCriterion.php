<?php

namespace Distil\Types;

use Distil\ActsAsCriteriaFactory;
use Distil\Criterion;
use Distil\Keywords\Keyword;
use Distil\Keywords\Value;

abstract class StringCriterion implements Criterion
{
    use ActsAsCriteriaFactory;

    private string $value;

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
