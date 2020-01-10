<?php

namespace Distil\Values;

trait ConstructsNullableKeyword
{
    public static function nullable(string $keyword): NullableKeyword
    {
        return new NullableKeyword($keyword, fn (...$arguments) => new self(...$arguments));
    }
}
