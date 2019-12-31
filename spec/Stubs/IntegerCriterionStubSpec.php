<?php

namespace spec\Distil\Stubs;

use Distil\Criteria;
use Distil\Criterion;
use Distil\Exceptions\InvalidCriterionValue;
use Distil\Stubs\IntegerCriterionStub;
use Distil\Types\IntegerCriterion;
use PhpSpec\ObjectBehavior;

class IntegerCriterionStubSpec extends ObjectBehavior
{
    private const VALUE = 6;

    public function let(): void
    {
        $this->beConstructedWith(self::VALUE);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(IntegerCriterion::class);
        $this->shouldHaveType(Criterion::class);
    }

    public function it_can_return_its_name(): void
    {
        $this->name()->shouldReturn(IntegerCriterionStub::NAME);
    }

    public function it_can_return_its_value(): void
    {
        $this->value()->shouldReturn(self::VALUE);
    }

    public function it_automatically_casts_numeric_value_to_an_integer(): void
    {
        $this->beConstructedWith('369');

        $this->value()->shouldReturn(369);
    }

    public function it_can_be_created_from_a_string_with_a_numeric_value(): void
    {
        $this->beConstructedThrough('fromString', ['6']);

        $this->value()->shouldReturn(6);
    }

    public function it_cannot_be_created_from_a_string_with_a_non_numeric_value(): void
    {
        $this->beConstructedThrough('fromString', ['rubbish']);

        $this->shouldThrow(InvalidCriterionValue::class)->duringInstantiation();
    }

    public function it_can_be_casted_to_a_string(): void
    {
        $this->__toString()->shouldReturn((string) self::VALUE);
    }

    public function it_can_act_as_criteria_factory(): void
    {
        $criteria = $this::criteria(self::VALUE);

        $criteria->shouldBeAnInstanceOf(Criteria::class);
        $criteria[IntegerCriterionStub::NAME]->value()->shouldReturn(self::VALUE);
    }
}
