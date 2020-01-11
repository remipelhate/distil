<?php

declare(strict_types=1);

namespace Distil\Values;

use DateTimeImmutable;
use DateTimeInterface;

final class ConstructsFromDateTimeTest extends ConstructsFromKeywordTestCase
{
    public function testItCanConstructWithADateTimeValue(): void
    {
        $instance = new FakeConstructsFromDateTime(
            new DateTimeImmutable('today'),
        );

        $this->assertInstanceOf(FakeConstructsFromDateTime::class, $instance);
    }

    public function testItCanReturnItsValue(): void
    {
        $instance = new FakeConstructsFromDateTime(
            new DateTimeImmutable('today'),
        );

        $this->assertEquals(new DateTimeImmutable('today'), $instance->value());
    }

    public function testItCanReturnItsFormat(): void
    {
        $instance = new FakeConstructsFromDateTime(
            new DateTimeImmutable('tomorrow'),
        );

        $this->assertSame(DateTimeInterface::ATOM, $instance->format());
    }

    public function testItCanConstructWithACustomFormat(): void
    {
        $instance = new FakeConstructsFromDateTime(
            new DateTimeImmutable('tomorrow'),
            'Ymd',
        );

        $this->assertSame('Ymd', $instance->format());
    }

    public function testItReturnsTheFormattedValueWhenCastingToAStringWhenNotConstructedFromAKeyword(): void
    {
        $constructsFromKeyword = new FakeConstructsFromDateTime(
            new DateTimeImmutable('2007-07-28 19:30:00'),
            'Y-m-d'
        );

        $this->assertSame('2007-07-28', (string) $constructsFromKeyword);
    }

    protected function keyword(): Keyword
    {
        return new DateTimeKeyword('2007-07-28 19:30:00');
    }

    protected function constructsFromKeyword(): object
    {
        return FakeConstructsFromDateTime::withOriginalValue();
    }
}

final class FakeConstructsFromDateTime
{
    use ConstructsFromDateTime;

    public const ORIGINAL_VALUE = '2007-07-28T19:30:00+00:00';

    public static function withOriginalValue(): self
    {
        return new self(new DateTimeImmutable(self::ORIGINAL_VALUE));
    }
}
