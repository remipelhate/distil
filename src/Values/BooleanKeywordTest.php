<?php

declare(strict_types=1);

namespace Distil\Values;

use Distil\Exceptions\InvalidKeyword;
use PHPUnit\Framework\TestCase;

final class BooleanKeywordTest extends TestCase
{
    public function testItFailsToInitializeWithAnInvalidValue(): void
    {
        $this->expectException(InvalidKeyword::class);

        new BooleanKeyword('rubbish');
    }

    public function testItCanCastValidTruthyKeywordsToABoolean(): void
    {
        $truthyKeyword = new BooleanKeyword('true');
        $numericTruthyKeyword = new BooleanKeyword('1');

        $this->assertEquals('true', (string) $truthyKeyword);
        $this->assertTrue($truthyKeyword->castedValue());
        $this->assertEquals('1', (string) $numericTruthyKeyword);
        $this->assertTrue($numericTruthyKeyword->castedValue());
    }

    public function testItCanCastValidFalsyKeywordsToABoolean(): void
    {
        $falsyKeyword = new BooleanKeyword('false');
        $numericFalsyKeyword = new BooleanKeyword('0');

        $this->assertEquals('false', (string) $falsyKeyword);
        $this->assertFalse($falsyKeyword->castedValue());
        $this->assertEquals('0', (string) $numericFalsyKeyword);
        $this->assertFalse($numericFalsyKeyword->castedValue());
    }

    public function testItImplementsTheKeywordInterface(): void
    {
        $keyword = new BooleanKeyword('true');

        $this->assertInstanceOf(Keyword::class, $keyword);
    }

    public function testItCanConstructANullableInstance(): void
    {
        $keyword = BooleanKeyword::nullable('true');

        $this->assertInstanceOf(NullableKeyword::class, $keyword);
        $this->assertEquals(new BooleanKeyword('true'), $keyword->deferredKeyword());
    }
}
