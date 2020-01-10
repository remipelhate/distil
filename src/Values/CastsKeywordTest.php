<?php

declare(strict_types=1);

namespace Distil\Values;

use PHPUnit\Framework\TestCase;

final class CastsKeywordTest extends CastsKeywordTestCase
{
    protected function keyword(): Keyword
    {
        return FakeKeyword::casted(FakeCastsKeyword::ORIGINAL_VALUE);
    }

    protected function castsKeyword(): object
    {
        return new FakeCastsKeyword();
    }
}

final class FakeCastsKeyword
{
    use CastsKeywords;

    public const ORIGINAL_VALUE = 'foo';

    private string $value = self::ORIGINAL_VALUE;
}
