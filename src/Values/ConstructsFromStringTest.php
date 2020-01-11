<?php

declare(strict_types=1);

namespace Distil\Values;

final class ConstructsFromStringTest extends ConstructsFromKeywordTestCase
{
    public function testItCanConstructWithAStringValue(): void
    {
        $instance = new FakeConstructsFromString('foo');

        $this->assertInstanceOf(FakeConstructsFromString::class, $instance);
    }

    public function testItCanReturnItsValue(): void
    {
        $instance = new FakeConstructsFromString('foo');

        $this->assertSame('foo', $instance->value());
    }

    protected function keyword(): Keyword
    {
        return FakeKeyword::casted('foo');
    }

    protected function constructsFromKeyword(): object
    {
        return FakeConstructsFromString::withOriginalValue();
    }
}

final class FakeConstructsFromString
{
    use ConstructsFromString;

    public const ORIGINAL_VALUE = 'foo';

    public static function withOriginalValue(): self
    {
        return new self(self::ORIGINAL_VALUE);
    }
}
