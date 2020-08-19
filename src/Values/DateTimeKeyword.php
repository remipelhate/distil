<?php

declare(strict_types=1);

namespace Distil\Values;

use DateTimeImmutable;
use DateTimeInterface;
use Distil\Exceptions\InvalidKeyword;

use function date_create;
use function is_numeric;
use function strtotime;

final class DateTimeKeyword implements Keyword
{
    use ConstructsNullableKeyword;

    private string $stringValue;
    private DateTimeInterface $castedValue;

    public function __construct(string $keyword)
    {
        $this->guardAgainstInvalidValues($keyword);
        $parsedKeyword = $this->isTimestamp($keyword) ? "@$keyword" : $keyword;

        $this->stringValue = $keyword;
        $this->castedValue = new DateTimeImmutable($parsedKeyword);
    }

    private function guardAgainstInvalidValues(string $keyword): void
    {
        if (! $this->isValidKeyword($keyword)) {
            throw InvalidKeyword::cannotBeCastedToDateTime($keyword);
        }
    }

    public function __toString(): string
    {
        return $this->stringValue;
    }

    public function castedValue(): DateTimeInterface
    {
        return $this->castedValue;
    }

    private function isValidKeyword(string $keyword): bool
    {
        return $this->isTimestamp($keyword) || strtotime($keyword) !== false;
    }

    private function isTimestamp(string $keyword): bool
    {
        return is_numeric($keyword) && date_create("@$keyword") !== false;
    }
}
