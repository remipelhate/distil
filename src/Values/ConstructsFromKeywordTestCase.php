<?php

declare(strict_types=1);

namespace Distil\Values;

use PHPUnit\Framework\TestCase;

use function get_class;

abstract class ConstructsFromKeywordTestCase extends TestCase
{
    abstract protected function keyword(): Keyword;
    abstract protected function constructsFromKeyword(): object;

    public function testItCanConstructTheImplementingClassFromAKeyword(): void
    {
        $keyword = $this->keyword();
        $castsKeyword = $this->constructsFromKeyword();

        $instance = $castsKeyword::fromKeyword($keyword);

        $this->assertInstanceOf(get_class($castsKeyword), $instance);
    }

    public function testItCanReturnTheKeyword(): void
    {
        $keyword = $this->keyword();
        $castsKeyword = $this->constructsFromKeyword();

        $instance = $castsKeyword::fromKeyword($keyword);

        $this->assertSame($keyword, $instance->keyword());
    }

    public function testItReturnsNullWhenNotConstructedFromAKeyword(): void
    {
        $castsKeyword = $this->constructsFromKeyword();

        $this->assertNull($castsKeyword->keyword());
    }

    public function testItReturnsTheKeywordWhenCastingToAString(): void
    {
        $keyword = $this->keyword();
        $castsKeyword = $this->constructsFromKeyword();

        $instance = $castsKeyword::fromKeyword($keyword);

        $this->assertSame((string) $keyword, (string) $instance);
    }

    public function testItReturnsTheStringValueWhenCastingToAStringWhenNotConstructedFromAKeyword(): void
    {
        $castsKeyword = $this->constructsFromKeyword();

        $this->assertSame((string) $castsKeyword::ORIGINAL_VALUE, (string) $castsKeyword);
    }
}
