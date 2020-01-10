<?php

declare(strict_types=1);

namespace Distil\Values;

use Distil\Exceptions\InvalidKeyword;

use function is_int;
use function is_numeric;

final class IntegerKeyword implements Keyword
{
    use ConstructsNullableKeyword;

    private string $stringValue;
    private int $castedValue;

    public function __construct(string $keyword)
    {
        $this->guardAgainstInvalidValues($keyword);

        $this->stringValue = $keyword;
        $this->castedValue = (int) $keyword;
    }

    private function guardAgainstInvalidValues(string $keyword): void
    {
        if (! $this->isInt($keyword)) {
            throw InvalidKeyword::cannotBeCastedToInteger($keyword);
        }
    }

    public function __toString(): string
    {
        return $this->stringValue;
    }

    public function castedValue(): int
    {
        return $this->castedValue;
    }

    private function isInt(string $keyword): bool
    {
        return is_numeric($keyword) && is_int($keyword + 0);
    }
}
