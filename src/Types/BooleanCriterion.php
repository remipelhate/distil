<?php

namespace Distil\Types;

use Distil\ActsAsCriteriaFactory;
use Distil\Criterion;
use Distil\Exceptions\InvalidCriterionValue;
use Distil\Keywords\HasKeywords;
use Distil\Keywords\Keyword;
use Distil\Keywords\Value;

abstract class BooleanCriterion implements Criterion, HasKeywords
{
    use ActsAsCriteriaFactory;

    const KEYWORD_TRUE = 'true';
    const KEYWORD_FALSE = 'false';

    /**
     * @var bool
     */
    private $value;

    public function __construct(bool $value)
    {
        $this->value = $value;
    }

    /**
     * @return static
     */
    public static function fromString(string $value): self
    {
        $value = (new Keyword(static::class, $value))->value();

        if (is_bool($value)) {
            return new static($value);
        }

        throw InvalidCriterionValue::expectedBoolean(static::class);
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
        return ! $this->isTruthy();
    }

    public static function keywords(): array
    {
        return [
            static::KEYWORD_TRUE => true,
            static::KEYWORD_FALSE => false,
        ];
    }

    public function __toString(): string
    {
        return (new Value($this, $this->value))->keyword();
    }
}
