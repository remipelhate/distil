<?php

declare(strict_types=1);

namespace Distil;

use Distil\Exceptions\CannotCreateCriterion;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class CriterionFactoryTest extends TestCase
{
    private const NAME = 'foo';
    private const VALUE = 'Some value';

    public function testItCannotBeConstructedWithResolversThatAreNotCallableOrAClassName(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new CriterionFactory(['foo' => 'rubbish']);
    }

    public function testItCannotCreateACriterionByNameWhenTheNameHasNoResolver(): void
    {
        $this->expectException(CannotCreateCriterion::class);

        (new CriterionFactory())->createByName('rubbish');
    }

    public function testItCanCreateACriterionInstanceByNameUsingTheCriterionClassName(): void
    {
        $factory = new CriterionFactory([self::NAME => FakeCriterion::class]);

        $criterion = $factory->createByName(self::NAME, self::NAME, self::VALUE);

        $this->assertInstanceOf(FakeCriterion::class, $criterion);
        $this->assertEquals(self::NAME, $criterion->name());
        $this->assertEquals(self::VALUE, $criterion->value());
    }

    public function testItCanCreateACriterionInstanceByNameUsingACallableStringResolver(): void
    {
        $factory = new CriterionFactory([self::NAME => FakeCriterion::class.'::make']);

        $criterion = $factory->createByName(self::NAME, self::NAME, self::VALUE);

        $this->assertInstanceOf(FakeCriterion::class, $criterion);
        $this->assertEquals(self::NAME, $criterion->name());
        $this->assertEquals(self::VALUE, $criterion->value());
    }

    public function testItCanCreateACriterionInstanceByNameUsingACallableResolver(): void
    {
        $factory = new CriterionFactory([self::NAME => function (...$arguments) {
            return new FakeCriterion(...$arguments);
        }]);

        $criterion = $factory->createByName(self::NAME, self::NAME, self::VALUE);

        $this->assertInstanceOf(FakeCriterion::class, $criterion);
        $this->assertEquals(self::NAME, $criterion->name());
        $this->assertEquals(self::VALUE, $criterion->value());
    }
}
