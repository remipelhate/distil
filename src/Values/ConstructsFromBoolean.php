<?php

declare(strict_types=1);

namespace Distil\Values;

use Distil\Exceptions\InvalidCriterionValue;

use function in_array;

trait ConstructsFromBoolean
{
    use ConstructsFromKeyword;

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
