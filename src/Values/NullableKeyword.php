<?php

declare(strict_types=1);

namespace Distil\Values;

use InvalidArgumentException;

final class NullableKeyword implements Keyword
{
    public const KEYWORD = 'null';

    private ?Keyword $deferredKeyword = null;

    public function __construct(string $keyword, callable $deferredKeyword)
    {
        if ($keyword !== self::KEYWORD) {
            $this->guardAgainstInvalidDeferredKeyword($keyword = $deferredKeyword($keyword));

            $this->deferredKeyword = $keyword;
        }
    }

    private function guardAgainstInvalidDeferredKeyword($keyword): void
    {
        if (! $keyword instanceof Keyword) {
            throw new InvalidArgumentException(
                'Argument 2 of ['.self::class.'] must be a callable returning a ['.Keyword::class.'] instance.'
            );
        }
    }

    public function __toString(): string
    {
        if ($this->deferredKeyword) {
            return (string) $this->deferredKeyword;
        }

        return self::KEYWORD;
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
