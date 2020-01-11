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
        $constructsFromKeyword = $this->constructsFromKeyword();

        $instance = $constructsFromKeyword::fromKeyword($keyword);

        $this->assertInstanceOf(get_class($constructsFromKeyword), $instance);
    }

    public function testItCanReturnTheKeyword(): void
    {
        $keyword = $this->keyword();
        $constructsFromKeyword = $this->constructsFromKeyword();

        $instance = $constructsFromKeyword::fromKeyword($keyword);

        $this->assertSame($keyword, $instance->keyword());
    }

    public function testItReturnsNullWhenNotConstructedFromAKeyword(): void
    {
        $constructsFromKeyword = $this->constructsFromKeyword();

        $this->assertNull($constructsFromKeyword->keyword());
    }

    public function testItReturnsTheKeywordWhenCastingToAString(): void
    {
        $keyword = $this->keyword();
        $constructsFromKeyword = $this->constructsFromKeyword();

        $instance = $constructsFromKeyword::fromKeyword($keyword);

        $this->assertSame((string) $keyword, (string) $instance);
    }

    public function testItReturnsTheStringValueWhenCastingToAStringWhenNotConstructedFromAKeyword(): void
    {
        $constructsFromKeyword = $this->constructsFromKeyword();

        $this->assertSame((string) $constructsFromKeyword::ORIGINAL_VALUE, (string) $constructsFromKeyword);
    }
}
