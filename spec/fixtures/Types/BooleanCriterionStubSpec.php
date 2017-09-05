<?php

namespace spec\fixtures\Fixtures\BeatSwitch\Distil\Types;

use BeatSwitch\Distil\Criteria;
use BeatSwitch\Distil\Criterion;
use BeatSwitch\Distil\Exceptions\InvalidCriterionValue;
use BeatSwitch\Distil\Keywords\Keywordable;
use BeatSwitch\Distil\Types\BooleanCriterion;
use Fixtures\BeatSwitch\Distil\Types\BooleanCriterionStub;
use PhpSpec\ObjectBehavior;

class BooleanCriterionStubSpec extends ObjectBehavior
{
    private const VALUE = true;

    function let()
    {
        $this->beConstructedWith(self::VALUE);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(BooleanCriterion::class);
        $this->shouldHaveType(Criterion::class);
        $this->shouldHaveType(Keywordable::class);
    }

    function it_can_return_its_name()
    {
        $this->name()->shouldReturn(BooleanCriterionStub::NAME);
    }

    function it_can_return_its_value()
    {
        $this->value()->shouldReturn(self::VALUE);
    }

    function it_can_check_if_it_is_truthy()
    {
        $this->isTruthy()->shouldReturn(true);
        $this->isFalsy()->shouldReturn(false);
    }

    function it_can_check_if_it_is_falsy()
    {
        $this->beConstructedWith(false);

        $this->isTruthy()->shouldReturn(false);
        $this->isFalsy()->shouldReturn(true);
    }

    function it_can_be_created_from_a_string_with_a_valid_truthy_value()
    {
        $this->beConstructedThrough('fromString', [BooleanCriterion::KEYWORD_TRUE]);

        $this->value()->shouldReturn(true);
    }

    function it_can_be_created_from_a_string_with_a_valid_falsy_value()
    {
        $this->beConstructedThrough('fromString', [BooleanCriterion::KEYWORD_FALSE]);

        $this->value()->shouldReturn(false);
    }

    function it_cannot_be_created_from_a_string_with_an_invalid_boolean_value()
    {
        $this->beConstructedThrough('fromString', ['1']);

        $this->shouldThrow(InvalidCriterionValue::class)->duringInstantiation();
    }

    function it_can_be_casted_to_a_string()
    {
        $this->__toString()->shouldReturn(BooleanCriterion::KEYWORD_TRUE);
    }

    function it_can_create_one_off_criteria()
    {
        $criteria = $this::criteria(self::VALUE);

        $criteria->shouldBeAnInstanceOf(Criteria::class);
        $criteria[BooleanCriterionStub::NAME]->value()->shouldReturn(self::VALUE);
    }
}
