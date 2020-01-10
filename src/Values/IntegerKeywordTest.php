<?php

declare(strict_types=1);

namespace Distil\Values;

use Distil\Exceptions\InvalidKeyword;
use PHPUnit\Framework\TestCase;

final class IntegerKeywordTest extends TestCase
{
    public function testItFailsToInitializeWithAnInvalidValue(): void
    {
        $this->expectException(InvalidKeyword::class);

        new IntegerKeyword('36.9');
    }

    public function testItCanCastValidIntegers(): void
    {
        $keyword = new IntegerKeyword('369');

        $this->assertEquals('369', (string) $keyword);
        $this->assertSame(369, $keyword->castedValue());
    }

    public function testItImplementsTheKeywordInterface(): void
    {
        $keyword = new IntegerKeyword('20070728');

        $this->assertInstanceOf(Keyword::class, $keyword);
    }

    public function testItCanConstructANullableInstance(): void
    {
        $keyword = IntegerKeyword::nullable('20070728');

        $this->assertInstanceOf(NullableKeyword::class, $keyword);
        $this->assertEquals(new IntegerKeyword('20070728'), $keyword->deferredKeyword());
    }
}
