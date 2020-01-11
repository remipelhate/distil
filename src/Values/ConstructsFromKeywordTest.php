<?php

declare(strict_types=1);

namespace Distil\Values;

final class ConstructsFromKeywordTest extends ConstructsFromKeywordTestCase
{
    protected function keyword(): Keyword
    {
        return FakeKeyword::casted(FakeCastsKeyword::ORIGINAL_VALUE);
    }

    protected function constructsFromKeyword(): object
    {
        return new FakeCastsKeyword();
    }
}

final class FakeCastsKeyword
{
    use ConstructsFromKeyword;

    public const ORIGINAL_VALUE = 'foo';

    private string $value = self::ORIGINAL_VALUE;
}
