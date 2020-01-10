<?php

declare(strict_types=1);

namespace Distil\Values;

final class ConstructsFromToIntegerTest extends ConstructsFromKeywordTestCase
{
    public function testItCanConstructWithAnIntegerValue(): void
    {
        $instance = new FakeConstructsFromInteger(20170728);

        $this->assertInstanceOf(FakeConstructsFromInteger::class, $instance);
    }

    public function testItCanReturnItsValue(): void
    {
        $instance = new FakeConstructsFromInteger(20170728);

        $this->assertSame(20170728, $instance->value());
    }

    protected function keyword(): Keyword
    {
        return new IntegerKeyword('20170728');
    }

    protected function constructsFromKeyword(): object
    {
        return FakeConstructsFromInteger::withOriginalValue();
    }
}

final class FakeConstructsFromInteger
{
    use ConstructsFromInteger;

    public const ORIGINAL_VALUE = 20170728;

    public static function withOriginalValue(): self
    {
        return new self(self::ORIGINAL_VALUE);
    }
}
