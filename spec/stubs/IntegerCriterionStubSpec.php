<?php

namespace spec\stubs\Stubs\BeatSwitch\Distil;

use BeatSwitch\Distil\Criteria;
use BeatSwitch\Distil\Criterion;
use BeatSwitch\Distil\Exceptions\InvalidCriterionValue;
use BeatSwitch\Distil\Types\IntegerCriterion;
use Stubs\BeatSwitch\Distil\IntegerCriterionStub;
use PhpSpec\ObjectBehavior;

class IntegerCriterionStubSpec extends ObjectBehavior
{
    private const VALUE = 6;

    function let()
    {
        $this->beConstructedWith(self::VALUE);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(IntegerCriterion::class);
        $this->shouldHaveType(Criterion::class);
    }

    function it_can_return_its_name()
    {
        $this->name()->shouldReturn(IntegerCriterionStub::NAME);
    }

    function it_can_return_its_value()
    {
        $this->value()->shouldReturn(self::VALUE);
    }

    function it_automatically_casts_numeric_value_to_an_integer()
    {
        $this->beConstructedWith('369');

        $this->value()->shouldReturn(369);
    }

    function it_can_be_created_from_a_string_with_a_numeric_value()
    {
        $this->beConstructedThrough('fromString', ['6']);

        $this->value()->shouldReturn(6);
    }

    function it_cannot_be_created_from_a_string_with_a_non_numeric_value()
    {
        $this->beConstructedThrough('fromString', ['rubbish']);

        $this->shouldThrow(InvalidCriterionValue::class)->duringInstantiation();
    }

    function it_can_be_casted_to_a_string()
    {
        $this->__toString()->shouldReturn((string) self::VALUE);
    }

    function it_can_create_one_off_criteria()
    {
        $criteria = $this::criteria(self::VALUE);

        $criteria->shouldBeAnInstanceOf(Criteria::class);
        $criteria[IntegerCriterionStub::NAME]->value()->shouldReturn(self::VALUE);
    }
}
