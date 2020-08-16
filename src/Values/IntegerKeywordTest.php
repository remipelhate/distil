<?php

declare(strict_types=1);

namespace Distil\Values;

use Distil\Exceptions\InvalidKeyword;
use PHPUnit\Framework\TestCase;

final class IntegerKeywordTest extends TestCase
{
    public function invalidStringValues(): array
    {
        return [
            ['36.9'],
            ['36,9'],
            ['nonsense'],
            ['true'],
        ];
    }

    /**
     * @test
     * @dataProvider invalidStringValues
     */
    public function it_fails_to_initialize_with_an_invalid_value(string $stringValue): void
    {
        $this->expectException(InvalidKeyword::class);

        new IntegerKeyword($stringValue);
    }

    /**
     * @test
     */
    public function it_implements_the_keyword_interface(): void
    {
        $keyword = new IntegerKeyword('20070728');

        $this->assertInstanceOf(Keyword::class, $keyword);
    }

    public function validStringValues(): array
    {
        return [
            [
                'string_value' => '369',
                'expected_casted_value' => 369,
            ],
            [
                'string_value' => '0',
                'expected_casted_value' => 0,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider validStringValues
     */
    public function it_can_return_its_casted_value(string $stringValue, int $expectedCastedValue): void
    {
        $keyword = new IntegerKeyword($stringValue);

        $this->assertSame($expectedCastedValue, $keyword->castedValue());
    }

    /**
     * @test
     * @dataProvider validStringValues
     */
    public function it_can_be_casted_to_a_string(string $stringValue): void
    {
        $keyword = new IntegerKeyword($stringValue);

        $this->assertEquals($stringValue, (string) $keyword);
    }

    /**
     * @test
     */
    public function it_can_be_initialized_to_accept_nullable_values(): void
    {
        $keyword = IntegerKeyword::nullable(NullableKeyword::VALUE);

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
        $keyword = IntegerKeyword::nullable($stringValue);

        $this->assertInstanceOf(NullableKeyword::class, $keyword);
        $this->assertEquals($expectedCastedValue, (new IntegerKeyword($stringValue))->castedValue());
        $this->assertEquals(new IntegerKeyword($stringValue), $keyword->deferredKeyword());
    }
}
