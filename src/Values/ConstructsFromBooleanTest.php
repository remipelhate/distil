<?php

declare(strict_types=1);

namespace Distil\Values;

final class ConstructsFromBooleanTest extends ConstructsFromKeywordTestCase
{
    public function testItCanConstructWithABooleanValue(): void
    {
        $truthy = new FakeConstructsFromBoolean(true);
        $falsy = new FakeConstructsFromBoolean(false);

        $this->assertInstanceOf(FakeConstructsFromBoolean::class, $truthy);
        $this->assertInstanceOf(FakeConstructsFromBoolean::class, $falsy);
    }

    public function testItCanReturnItsValue(): void
    {
        $truthy = new FakeConstructsFromBoolean(true);
        $falsy = new FakeConstructsFromBoolean(false);

        $this->assertTrue($truthy->value());
        $this->assertFalse($falsy->value());
    }

    public function testItCanCheckIfItIsTruthy(): void
    {
        $truthy = new FakeConstructsFromBoolean(true);
        $falsy = new FakeConstructsFromBoolean(false);

        $this->assertTrue($truthy->isTruthy());
        $this->assertFalse($falsy->isTruthy());
    }

    public function testItCanCheckIfItIsFalsy(): void
    {
        $truthy = new FakeConstructsFromBoolean(true);
        $falsy = new FakeConstructsFromBoolean(false);

        $this->assertFalse($truthy->isFalsy());
        $this->assertTrue($falsy->isFalsy());
    }

    protected function keyword(): Keyword
    {
        return FakeKeyword::casted(true);
    }

    protected function constructsFromKeyword(): object
    {
        return FakeConstructsFromBoolean::withOriginalValue();
    }
}

final class FakeConstructsFromBoolean
{
    use ConstructsFromBoolean;

    public const ORIGINAL_VALUE = true;

    public static function withOriginalValue(): self
    {
        return new self(self::ORIGINAL_VALUE);
    }
}
