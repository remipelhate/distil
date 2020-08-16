<?php

declare(strict_types=1);

namespace Distil\Values;

use Distil\Exceptions\InvalidKeyword;
use PHPUnit\Framework\TestCase;

final class BooleanKeywordTest extends TestCase
{
    /**
     * @test
     */
    public function it_fails_to_initialize_with_an_invalid_keyword(): void
    {
        $invalidValue = 'rubbish';

        $this->expectExceptionObject(InvalidKeyword::cannotBeCastedToBoolean($invalidValue));

        new BooleanKeyword($invalidValue);
    }

    /**
     * @test
     */
    public function it_implements_the_keyword_interface(): void
    {
        $keyword = new BooleanKeyword('true');

        $this->assertInstanceOf(Keyword::class, $keyword);
    }

    public function validStringValues(): array
    {
        return [
            [
                'string_value' => 'true',
                'expected_casted_value' => true,
            ],
            [
                'string_value' => '1',
                'expected_casted_value' => true,
            ],
            [
                'string_value' => 'false',
                'expected_casted_value' => false,
            ],
            [
                'string_value' => '0',
                'expected_casted_value' => false,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider validStringValues
     */
    public function it_can_return_its_casted_value(string $stringValue, bool $expectedCastedValue): void
    {
        $this->assertSame($expectedCastedValue, (new BooleanKeyword($stringValue))->castedValue());
    }

    /**
     * @test
     * @dataProvider validStringValues
     */
    public function it_can_be_casted_to_a_string(string $keyword): void
    {
        $this->assertSame($keyword, (string) new BooleanKeyword($keyword));
    }

    /**
     * @test
     */
    public function it_can_be_initialized_to_accept_nullable_values(): void
    {
        $keyword = BooleanKeyword::nullable(NullableKeyword::VALUE);

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
        $keyword = BooleanKeyword::nullable($stringValue);

        $this->assertInstanceOf(NullableKeyword::class, $keyword);
        $this->assertEquals($expectedCastedValue, (new BooleanKeyword($stringValue))->castedValue());
        $this->assertEquals(new BooleanKeyword($stringValue), $keyword->deferredKeyword());
    }
}
