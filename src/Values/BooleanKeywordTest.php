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

        $this->assertEquals('true', $truthyKeyword->__toString());
        $this->assertTrue($truthyKeyword->castedValue());
        $this->assertEquals('1', $numericTruthyKeyword->__toString());
        $this->assertTrue($numericTruthyKeyword->castedValue());
    }

    public function testItCanCastValidFalsyKeywordsToABoolean(): void
    {
        $falsyKeyword = new BooleanKeyword('false');
        $numericFalsyKeyword = new BooleanKeyword('0');

        $this->assertEquals('false', $falsyKeyword->__toString());
        $this->assertFalse($falsyKeyword->castedValue());
        $this->assertEquals('0', $numericFalsyKeyword->__toString());
        $this->assertFalse($numericFalsyKeyword->castedValue());
    }

    public function testItImplementsTheKeywordInterface(): void
    {
        $keyword = new BooleanKeyword('true');

        $this->assertInstanceOf(Keyword::class, $keyword);
    }
}
