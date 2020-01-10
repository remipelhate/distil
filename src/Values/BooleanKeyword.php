<?php

declare(strict_types=1);

namespace Distil\Values;

use Distil\Exceptions\InvalidKeyword;

use function array_keys;
use function array_key_exists;

final class BooleanKeyword implements Keyword
{
    public const CASTED_VALUES = [
        'true' => true,
        '1' => true,
        'false' => false,
        '0' => false,
    ];

    private string $stringValue;
    private bool $castedValue;

    public function __construct(string $keyword)
    {
        $this->guardAgainstInvalidValues($keyword);

        $this->stringValue = $keyword;
        $this->castedValue = self::CASTED_VALUES[$keyword];
    }

    private function guardAgainstInvalidValues(string $keyword): void
    {
        if ($this->isNotAKeyword($keyword)) {
            throw InvalidKeyword::cannotBeCastedToBoolean($keyword);
        }
    }

    public function __toString(): string
    {
        return $this->stringValue;
    }

    public function castedValue(): bool
    {
        return $this->castedValue;
    }

    private function isNotAKeyword(string $keyword): bool
    {
        return ! array_key_exists($keyword, self::CASTED_VALUES);
    }
}
