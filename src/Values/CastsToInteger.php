<?php

declare(strict_types=1);

namespace Distil\Values;

use Distil\Exceptions\InvalidCriterionValue;

trait CastsToInteger
{
    use CastsKeywords;

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
