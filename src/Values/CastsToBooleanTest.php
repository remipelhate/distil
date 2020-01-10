<?php

declare(strict_types=1);

namespace Distil\Values;

final class CastsToBooleanTest extends CastsKeywordTestCase
{
    public function testItCanConstructWithATBooleanValue(): void
    {
        $truthy = new FakeCastsToBoolean(true);
        $falsy = new FakeCastsToBoolean(false);

        $this->assertInstanceOf(FakeCastsToBoolean::class, $truthy);
        $this->assertInstanceOf(FakeCastsToBoolean::class, $falsy);
    }

    public function testItCanReturnItsValue(): void
    {
        $truthy = new FakeCastsToBoolean(true);
        $falsy = new FakeCastsToBoolean(false);

        $this->assertTrue($truthy->value());
        $this->assertFalse($falsy->value());
    }

    public function testItCanCheckIfItIsTruthy(): void
    {
        $truthy = new FakeCastsToBoolean(true);
        $falsy = new FakeCastsToBoolean(false);

        $this->assertTrue($truthy->isTruthy());
        $this->assertFalse($falsy->isTruthy());
    }

    public function testItCanCheckIfItIsFalsy(): void
    {
        $truthy = new FakeCastsToBoolean(true);
        $falsy = new FakeCastsToBoolean(false);

        $this->assertFalse($truthy->isFalsy());
        $this->assertTrue($falsy->isFalsy());
    }

    protected function keyword(): Keyword
    {
        return FakeKeyword::casted(true);
    }

    protected function castsKeyword(): object
    {
        return FakeCastsToBoolean::withOriginalValue();
    }
}

final class FakeCastsToBoolean
{
    use CastsToBoolean;

    public const ORIGINAL_VALUE = true;

    public static function withOriginalValue(): self
    {
        return new self(self::ORIGINAL_VALUE);
    }
}
