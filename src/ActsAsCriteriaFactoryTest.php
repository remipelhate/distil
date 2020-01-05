<?php

declare(strict_types=1);

namespace Distil;

use PHPUnit\Framework\TestCase;

final class ActsAsCriteriaFactoryTest extends TestCase
{
    private const NAME = 'foo';
    private const VALUE = 'Some value';

    public function testItCanCreateACriteriaInstanceWithItselfAsAnArgument(): void
    {
        $criteria = CriteriaFactory::criteria(self::NAME, self::VALUE);

        $this->assertInstanceOf(Criteria::class, $criteria);
        $this->assertTrue($criteria->has(self::NAME));
        $this->assertInstanceOf(CriteriaFactory::class, $criterion = $criteria->get(self::NAME));
        $this->assertEquals(self::VALUE, $criterion->value());
    }
}

final class CriteriaFactory implements Criterion
{
    use ActsAsCriteriaFactory;

    private string $name;
    private $value;

    public function __construct(string $name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function value()
    {
        return $this->value;
    }
}
