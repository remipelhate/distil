<?php

namespace spec\Distil\Stubs;

use Distil\Criteria;
use Distil\Criterion;
use Distil\Exceptions\InvalidCriterionValue;
use Distil\Stubs\ListCriterionStub;
use Distil\Types\ListCriterion;
use PhpSpec\ObjectBehavior;

class ListCriterionStubSpec extends ObjectBehavior
{
    private const VALUE = ['foo', 'bar'];
    private const STRING_VALUE = 'foo,bar';

    public function let(): void
    {
        $this->beConstructedWith(...self::VALUE);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ListCriterion::class);
        $this->shouldHaveType(Criterion::class);
    }

    public function it_cannot_be_created_with_mixed_value_types(): void
    {
        $this->beConstructedWith(1, 'foo');

        $this->shouldThrow(InvalidCriterionValue::class)->duringInstantiation();
    }

    public function it_can_return_its_name(): void
    {
        $this->name()->shouldReturn(ListCriterionStub::NAME);
    }

    public function it_can_return_its_value(): void
    {
        $this->value()->shouldReturn(self::VALUE);
    }

    public function it_can_be_created_from_a_string(): void
    {
        $this->beConstructedThrough('fromString', [self::STRING_VALUE]);

        $this->value()->shouldReturn(self::VALUE);
    }

    public function it_can_be_casted_to_a_string(): void
    {
        $this->__toString()->shouldReturn(self::STRING_VALUE);
    }

    public function it_can_act_as_criteria_factory(): void
    {
        $criteria = $this::criteria(1, 6);

        $criteria->shouldReturnAnInstanceOf(Criteria::class);
        $criteria[ListCriterionStub::NAME]->value()->shouldReturn([1, 6]);
    }
}
