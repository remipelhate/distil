<?php

declare(strict_types=1);

namespace Distil\Values;

trait ConstructsFromString
{
    use ConstructsFromKeyword;

    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
