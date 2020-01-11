<?php

declare(strict_types=1);

namespace Distil\Values;

use DateTimeImmutable;
use Distil\Exceptions\InvalidKeyword;
use PHPUnit\Framework\TestCase;

final class DateTimeKeywordTest extends TestCase
{
    public function testItFailsToInitializeWithAnInvalidValue(): void
    {
        $this->expectException(InvalidKeyword::class);

        new DateTimeKeyword('nonsense');
    }

    public function testItCanCastReadableDateTimeStrings(): void
    {
        $today = new DateTimeKeyword($todayString = 'today');
        $future = new DateTimeKeyword($futureString = 'tomorrow + 6days');

        $this->assertEquals($todayString, (string) $today);
        $this->assertEquals(new DateTimeImmutable($todayString), $today->castedValue());
        $this->assertEquals($futureString, (string) $future);
        $this->assertEquals(new DateTimeImmutable($futureString), $future->castedValue());
    }

    public function testItCanCastTimestampStrings(): void
    {
        $timestamp = strtotime('2007-07-28 19:30:00');
        $keyword = new DateTimeKeyword((string) $timestamp);

        $this->assertEquals($timestamp, (string) $keyword);
        $this->assertEquals(new DateTimeImmutable("@$timestamp"), $keyword->castedValue());
    }

    public function testItCanCastFormattedDateTimeStrings(): void
    {
        $formattedDateTimeString = '2007-07-28 19:30:00';
        $keyword = new DateTimeKeyword($formattedDateTimeString);

        $this->assertEquals($formattedDateTimeString, (string) $keyword);
        $this->assertEquals(new DateTimeImmutable($formattedDateTimeString), $keyword->castedValue());
    }

    public function testItImplementsTheKeywordInterface(): void
    {
        $keyword = new DateTimeKeyword('today');

        $this->assertInstanceOf(Keyword::class, $keyword);
    }

    public function testItCanConstructANullableInstance(): void
    {
        $keyword = DateTimeKeyword::nullable('today');

        $this->assertInstanceOf(NullableKeyword::class, $keyword);
        $this->assertEquals(new DateTimeKeyword('today'), $keyword->deferredKeyword());
    }
}
