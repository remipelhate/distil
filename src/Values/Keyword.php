<?php

declare(strict_types=1);

namespace Distil\Values;

interface Keyword
{
    public function __toString(): string;
    public function castedValue();
}
