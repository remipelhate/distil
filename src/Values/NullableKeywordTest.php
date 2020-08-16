<?php

declare(strict_types=1);

namespace Distil\Values;

use PHPUnit\Framework\TestCase;
use TypeError;

final class NullableKeywordTest extends TestCase
{
    private const EXPECTED_VALUE = 'null';

    /**
     * @test
     */
    public function it_fails_with_an_invalid_keyword_factory(): void
    {
        $this->expectException(TypeError::class);

        new NullableKeyword('foo', fn () => 'invalid deferred keyword');
    }

    /**
     * @test
     */
    public function it_implements_the_keyword_interface(): void
    {
        $keyword = new NullableKeyword('null', fn () => null);

        $this->assertInstanceOf(Keyword::class, $keyword);
    }

    /**
     * @test
     */
    public function it_can_cast_the_null_keyword_to_the_null_value(): void
    {
        $keyword = new NullableKeyword(self::EXPECTED_VALUE, fn (string $keyword) => FakeKeyword::casted($keyword));

        $this->assertSame(self::EXPECTED_VALUE, (string) $keyword);
        $this->assertNull($keyword->castedValue());
        $this->assertNull($keyword->deferredKeyword());
    }

    /**
     * @test
     */
    public function it_uses_the_deferred_keyword_when_the_keyword_value_is_not_null(): void
    {
        $keyword = new NullableKeyword('foo', fn (string $keyword) => FakeKeyword::casted($keyword));

        $this->assertSame(FakeKeyword::VALUE, (string) $keyword);
        $this->assertSame('foo', $keyword->castedValue());
        $this->assertInstanceOf(FakeKeyword::class, $keyword->deferredKeyword());
    }
}
