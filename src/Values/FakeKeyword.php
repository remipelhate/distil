<?php

declare(strict_types=1);

namespace Distil\Values;

final class FakeKeyword implements Keyword
{
    private string $keyword;

    /**
     * @var mixed
     */
    private $castedValue;

    private function __construct($keyword, $castedValue)
    {
        $this->castedValue = $castedValue;
        $this->keyword = $keyword;
    }

    public static function casted($value, string $keyword = 'keyword'): self
    {
        return new self($keyword, $value);
    }

    public function __toString(): string
    {
        return $this->keyword;
    }

    public function castedValue()
    {
        return $this->castedValue;
    }
}
