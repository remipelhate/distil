<?php

declare(strict_types=1);

namespace Distil\Values;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class NullableKeywordTest extends TestCase
{
    private const KEYWORD = 'null';

    public function testItFailsWithAnInvalidKeywordFactory(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new NullableKeyword('foo', fn () => 'invalid deferred keyword');
    }

    public function testItCanCastTheNullKeywordToTheNullValue(): void
    {
        $keyword = new NullableKeyword(self::KEYWORD, fn (...$arguments) => FakeKeyword::casted(...$arguments));

        $this->assertEquals(self::KEYWORD, (string) $keyword);
        $this->assertNull($keyword->castedValue());
        $this->assertNull($keyword->deferredKeyword());
    }

    public function testItUsesTheDeferredKeywordWhenTheKeywordValueIsNotNull(): void
    {
        $keyword = new NullableKeyword('foo', fn (...$arguments) => FakeKeyword::casted(...$arguments));

        $this->assertEquals(FakeKeyword::STRING_VALUE, (string) $keyword);
        $this->assertEquals('foo', $keyword->castedValue());
        $this->assertInstanceOf(FakeKeyword::class, $keyword->deferredKeyword());
    }

    public function testItImplementsTheKeywordInterface(): void
    {
        $keyword = new NullableKeyword('null', fn () => null);

        $this->assertInstanceOf(Keyword::class, $keyword);
    }
}
