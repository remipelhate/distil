<?php

declare(strict_types=1);

namespace Distil\Values;

use PHPUnit\Framework\TestCase;

use function get_class;

final class ConstructsFromKeywordTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_construct_the_implementing_class_from_a_keyword(): void
    {
        $keyword = FakeKeyword::casted(FakeCastsKeyword::ORIGINAL_VALUE);
        $constructsFromKeyword = new FakeCastsKeyword();

        $instance = $constructsFromKeyword::fromKeyword($keyword);

        $this->assertInstanceOf(get_class($constructsFromKeyword), $instance);
    }

    /**
     * @test
     */
    public function it_can_return_the_keyword(): void
    {
        $keyword = FakeKeyword::casted(FakeCastsKeyword::ORIGINAL_VALUE);
        $constructsFromKeyword = new FakeCastsKeyword();

        $instance = $constructsFromKeyword::fromKeyword($keyword);

        $this->assertSame($keyword, $instance->keyword());
    }

    /**
     * @test
     */
    public function it_returns_null_when_not_constructed_from_a_keyword(): void
    {
        $constructsFromKeyword = new FakeCastsKeyword();

        $this->assertNull($constructsFromKeyword->keyword());
    }

    /**
     * @test
     */
    public function it_returns_the_keyword_when_casting_to_a_string(): void
    {
        $keyword = FakeKeyword::casted(FakeCastsKeyword::ORIGINAL_VALUE);
        $constructsFromKeyword = new FakeCastsKeyword();

        $instance = $constructsFromKeyword::fromKeyword($keyword);

        $this->assertSame((string) $keyword, (string) $instance);
    }

    /**
     * @test
     */
    public function it_returns_the_string_value_when_casting_to_a_string_when_not_constructed_from_a_keyword(): void
    {
        $constructsFromKeyword = new FakeCastsKeyword();

        $this->assertSame((string) $constructsFromKeyword::ORIGINAL_VALUE, (string) $constructsFromKeyword);
    }
}

final class FakeCastsKeyword
{
    use ConstructsFromKeyword;

    public const ORIGINAL_VALUE = 'foo';

    private string $value = self::ORIGINAL_VALUE;
}
