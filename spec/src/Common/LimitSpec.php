<?php

namespace spec\src\BeatSwitch\Distil\Common;

use BeatSwitch\Distil\Common\Limit;
use BeatSwitch\Distil\Exceptions\InvalidCriterionValue;
use BeatSwitch\Distil\Exceptions\InvalidLimit;
use BeatSwitch\Distil\Keywords\Keywordable;
use BeatSwitch\Distil\Types\IntegerCriterion;
use PhpSpec\ObjectBehavior;

class LimitSpec extends ObjectBehavior
{
    private const VALUE = 6;

    function let()
    {
        $this->beConstructedWith(self::VALUE);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Limit::class);
    }

    function it_extends_the_integer_criterion()
    {
        $this->shouldHaveType(IntegerCriterion::class);
    }

    function it_is_keywordable()
    {
        $this->shouldHaveType(Keywordable::class);
    }

    function it_cannot_be_created_with_a_zero_value()
    {
        $this->beConstructedWith(0);

        $this->shouldThrow(InvalidLimit::class)->duringInstantiation();
    }

    function it_can_be_created_without_a_limit_value()
    {
        $this->beConstructedWith(null);
    }

    function it_can_return_its_name()
    {
        $this->name()->shouldReturn(Limit::NAME);
    }

    function it_can_return_its_value()
    {
        $this->value()->shouldReturn(self::VALUE);
    }

    function it_can_be_created_from_a_string()
    {
        $this->beConstructedThrough('fromString', [(string) self::VALUE]);

        $this->value()->shouldReturn(self::VALUE);
    }

    function it_cannot_be_created_from_a_string_with_an_invalid_keyword()
    {
        $this->beConstructedThrough('fromString', ['rubbish']);

        $this->shouldThrow(InvalidCriterionValue::class)->duringInstantiation();
    }

    function it_can_be_created_from_a_string_with_the_all_keyword()
    {
        $this->beConstructedThrough('fromString', [Limit::ALL_KEYWORD]);

        $this->value()->shouldReturn(Limit::ALL);
    }

    function it_is_not_unlimited_when_it_has_a_numeric_value()
    {
        $this->isUnlimited()->shouldReturn(false);
    }

    function it_is_unlimited_when_it_has_a_null_value()
    {
        $this->beConstructedWith(null);

        $this->isUnlimited()->shouldReturn(true);
    }
}
