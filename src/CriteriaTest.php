<?php

declare(strict_types=1);

namespace Distil;

use Distil\Exceptions\CannotAddCriterion;
use Distil\Exceptions\CannotGetCriterion;
use PHPUnit\Framework\TestCase;

use function array_values;

final class CriteriaTest extends TestCase
{
    public function testItCanBeInitializedWithoutCriterion(): void
    {
        $criteria = new Criteria();

        $this->assertInstanceOf(Criteria::class, $criteria);
    }

    public function testItCannotBeInitializedWithDuplicateCriterion(): void
    {
        $this->expectException(CannotAddCriterion::class);

        new Criteria(
            new FakeCriterion('foo', null),
            new FakeCriterion('foo', 'value'),
        );
    }

    public function testItCanReturnAllItsItems(): void
    {
        $items = [
            'foo' => new FakeCriterion('foo', null),
            'bar' => new FakeCriterion('bar', 'value'),
            'baz' => new FakeCriterion('baz', 28),
        ];
        $criteria = new Criteria(...array_values($items));

        $this->assertSame($items, $criteria->all());
    }

    public function testItReturnsTrueWhenItIEmpty(): void
    {
        $criteria = new Criteria();

        $this->assertTrue($criteria->isEmpty());
    }

    public function testItReturnsFalseWhenItIsNotEmpty(): void
    {
        $criteria = FakeCriterion::criteria('foo', null);

        $this->assertFalse($criteria->isEmpty());
    }

    public function testItCanCheckIfItHasCriteriaWithAGivenName(): void
    {
        $criteria = FakeCriterion::criteria('foo', null);

        $this->assertTrue($criteria->has('foo'));
        $this->assertFalse($criteria->has('bar'));
    }

    public function testItCanFindACriterionByName(): void
    {
        $expectedCriterion = new FakeCriterion('foo', null);
        $criteria = new Criteria($expectedCriterion);

        $criterion = $criteria->find('foo');

        $this->assertSame($expectedCriterion, $criterion);
    }

    public function testItReturnsNullWhenItCannotFindACriterionByName(): void
    {
        $criteria = FakeCriterion::criteria('foo', null);

        $criterion = $criteria->find('bar');

        $this->assertNull($criterion);
    }

    public function testItCanGetACriterionByName(): void
    {
        $expectedCriterion = new FakeCriterion('foo', null);
        $criteria = new Criteria($expectedCriterion);

        $criterion = $criteria->get('foo');

        $this->assertSame($expectedCriterion, $criterion);
    }

    public function testItThrowsAnErrorWhenItCannotGetACriterionByName(): void
    {
        $this->expectException(CannotGetCriterion::class);

        $criteria = FakeCriterion::criteria('foo', null);

        $criteria->get('bar');
    }

    public function testItCanAddANewCriterion(): void
    {
        $criteria = FakeCriterion::criteria('foo', null);

        $result = $criteria->add(new FakeCriterion('bar', null));

        $this->assertInstanceOf(Criteria::class, $result);
        $this->assertTrue($criteria->has('bar'));
    }

    public function testItCannotAddACriterionWhenTheNameIsAlreadyTaken(): void
    {
        $this->expectException(CannotAddCriterion::class);

        $criteria = FakeCriterion::criteria('foo', null);

        $criteria->add(new FakeCriterion('foo', 'value'));
    }

    public function testItCanSetANewCriterion(): void
    {
        $criteria = FakeCriterion::criteria('foo', null);

        $result = $criteria->set(new FakeCriterion('bar', null));

        $this->assertInstanceOf(Criteria::class, $result);
        $this->assertTrue($criteria->has('bar'));
    }

    public function testItCanSetACriterionWhenTheNameIsAlreadyTaken(): void
    {
        $criteria = FakeCriterion::criteria('foo', null);

        $result = $criteria->set(new FakeCriterion('foo', 'value'));

        $this->assertInstanceOf(Criteria::class, $result);
        $this->assertSame('value', $criteria->get('foo')->value());
    }
}
