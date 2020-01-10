<?php

declare(strict_types=1);

namespace Distil\Values;

final class CastsToIntegerTest extends CastsKeywordTestCase
{
    public function testItCanConstructWithAnIntegerValue(): void
    {
        $instance = new FakeCastsToInteger(20170728);

        $this->assertInstanceOf(FakeCastsToInteger::class, $instance);
    }

    public function testItCanReturnItsValue(): void
    {
        $instance = new FakeCastsToInteger(20170728);

        $this->assertSame(20170728, $instance->value());
    }

    protected function keyword(): Keyword
    {
        return new IntegerKeyword('20170728');
    }

    protected function castsKeyword(): object
    {
        return FakeCastsToInteger::withOriginalValue();
    }
}

final class FakeCastsToInteger
{
    use CastsToInteger;

    public const ORIGINAL_VALUE = 20170728;

    public static function withOriginalValue(): self
    {
        return new self(self::ORIGINAL_VALUE);
    }
}
