<?php

declare(strict_types=1);

namespace Distil\Values;

use DateTimeImmutable;
use Distil\Exceptions\InvalidKeyword;
use PHPUnit\Framework\TestCase;

use function strtotime;

final class DateTimeKeywordTest extends TestCase
{
    /**
     * @test
     */
    public function it_fails_to_initialize_with_an_invalid_value(): void
    {
        $keyword = 'nonsense';

        $this->expectExceptionObject(InvalidKeyword::cannotBeCastedToDateTime($keyword));

        new DateTimeKeyword($keyword);
    }

    /**
     * @test
     */
    public function it_implements_the_keyword_interface(): void
    {
        $keyword = new DateTimeKeyword('today');

        $this->assertInstanceOf(Keyword::class, $keyword);
    }

    public function validStringValues(): array
    {
        return [
            [
                'string_value' => $today = 'today',
                'expected_casted_value' => new DateTimeImmutable($today),
            ],
            [
                'string_value' => $tomorrow = 'today +1 days',
                'expected_casted_value' => new DateTimeImmutable($tomorrow),
            ],
            [
                'string_value' => $timestamp = (string) strtotime('2007-07-28 19:30:00'),
                'expected_casted_value' => new DateTimeImmutable("@$timestamp"),
            ],
            [
                'string_value' => $formatted = '2007-07-28 19:30:00',
                'expected_casted_value' => new DateTimeImmutable($formatted),
            ],
        ];
    }

    /**
     * @test
     * @dataProvider validStringValues
     */
    public function it_can_return_its_casted_value(string $stringValue, DateTimeImmutable $expectedCastedValue): void
    {
        $keyword = new DateTimeKeyword($stringValue);

        $this->assertEquals($expectedCastedValue, $keyword->castedValue());
    }

    /**
     * @test
     * @dataProvider validStringValues
     */
    public function it_can_be_casted_to_a_string(string $stringValue): void
    {
        $keyword = new DateTimeKeyword($stringValue);

        $this->assertEquals($stringValue, (string) $keyword);
    }

    /**
     * @test
     */
    public function it_can_be_initialized_to_accept_nullable_values(): void
    {
        $keyword = DateTimeKeyword::nullable(NullableKeyword::VALUE);

        $this->assertInstanceOf(NullableKeyword::class, $keyword);
        $this->assertSame(null, $keyword->castedValue());
        $this->assertNull($keyword->deferredKeyword());
    }

    /**
     * @test
     * @dataProvider validStringValues
     */
    public function it_returns_the_deferred_keyword_when_accepting_nullable_values_but_the_value_is_not_nullable(
        string $stringValue,
        $expectedCastedValue
    ): void {
        $keyword = DateTimeKeyword::nullable($stringValue);

        $this->assertInstanceOf(NullableKeyword::class, $keyword);
        $this->assertEquals($expectedCastedValue, (new DateTimeKeyword($stringValue))->castedValue());
        $this->assertEquals(new DateTimeKeyword($stringValue), $keyword->deferredKeyword());
    }
}
