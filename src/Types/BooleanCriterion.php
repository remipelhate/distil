<?php

namespace Distil\Types;

use Distil\ActsAsCriteriaFactory;
use Distil\Criterion;
use Distil\Values\BooleanKeyword;
use Distil\Values\ConstructsFromKeyword;

abstract class BooleanCriterion implements Criterion
{
    use ActsAsCriteriaFactory;
    use ConstructsFromKeyword;

    public const KEYWORD_TRUE = 'true';
    public const KEYWORD_FALSE = 'false';

    private bool $value;

    public function __construct(bool $value)
    {
        $this->value = $value;
    }

    /**
     * @return static
     */
    public static function fromString(string $value): self
    {
        return self::fromKeyword(new BooleanKeyword($value));
    }

    public function value(): bool
    {
        return $this->value;
    }

    public function isTruthy(): bool
    {
        return $this->value;
    }

    public function isFalsy(): bool
    {
        return ! $this->value;
    }
}
