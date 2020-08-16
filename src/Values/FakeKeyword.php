<?php

declare(strict_types=1);

namespace Distil\Values;

/**
 * @internal
 */
final class FakeKeyword implements Keyword
{
    public const VALUE = 'keyword';

    private string $stringValue;

    /**
     * @var mixed
     */
    private $castedValue;

    private function __construct($keyword, $castedValue)
    {
        $this->stringValue = $keyword;
        $this->castedValue = $castedValue;
    }

    public static function casted($value, string $keyword = self::VALUE): self
    {
        return new self($keyword, $value);
    }

    public function __toString(): string
    {
        return $this->stringValue;
    }

    public function castedValue()
    {
        return $this->castedValue;
    }
}
