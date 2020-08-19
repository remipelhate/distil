<?php

declare(strict_types=1);

namespace Distil\Values;

final class NullableKeyword implements Keyword
{
    public const VALUE = 'null';

    private ?Keyword $deferredKeyword = null;

    public function __construct(string $keyword, callable $deferredKeyword)
    {
        if (! $this->isNullValue($keyword)) {
            $this->deferredKeyword = $deferredKeyword($keyword);
        }
    }

    private function isNullValue(string $keyword): bool
    {
        return $keyword === self::VALUE;
    }

    public function __toString(): string
    {
        if ($this->deferredKeyword) {
            return (string) $this->deferredKeyword;
        }

        return self::VALUE;
    }

    public function castedValue()
    {
        if ($this->deferredKeyword) {
            return $this->deferredKeyword->castedValue();
        }

        return null;
    }

    public function deferredKeyword(): ?Keyword
    {
        return $this->deferredKeyword;
    }
}
