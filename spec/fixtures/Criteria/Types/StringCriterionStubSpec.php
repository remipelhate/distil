<?php

namespace spec\fixtures\Fixtures\BeatSwitch\Distil\Criteria\Types;

use BeatSwitch\Distil\Criteria;
use BeatSwitch\Distil\Criteria\Criterion;
use BeatSwitch\Distil\Criteria\Types\StringCriterion;
use Fixtures\BeatSwitch\Distil\Criteria\Types\StringCriterionStub;
use PhpSpec\ObjectBehavior;

class StringCriterionStubSpec extends ObjectBehavior
{
    private const VALUE = 'Some String Value';

    function let()
    {
        $this->beConstructedWith(self::VALUE);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(StringCriterion::class);
        $this->shouldHaveType(Criterion::class);
    }

    function it_can_return_its_name()
    {
        $this->name()->shouldReturn(StringCriterionStub::NAME);
    }

    function it_can_return_its_value()
    {
        $this->value()->shouldReturn(self::VALUE);
    }

    function it_can_be_casted_to_a_string()
    {
        $this->__toString()->shouldReturn(self::VALUE);
    }

    function it_can_create_one_off_criteria()
    {
        $criteria = $this::criteria(self::VALUE);

        $criteria->shouldReturnAnInstanceOf(Criteria::class);
        $criteria[StringCriterionStub::NAME]->value()->shouldReturn(self::VALUE);
    }
}
