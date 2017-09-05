<?php

namespace spec\Distil\Common;

use Distil\Common\Limit;
use Distil\Exceptions\InvalidCriterionValue;
use Distil\Exceptions\InvalidLimit;
use Distil\Keywords\HasKeywords;
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

    function it_is_keywordable()
    {
        $this->shouldHaveType(HasKeywords::class);
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
        $this->beConstructedThrough('fromString', [Limit::KEYWORD_UNLIMITED]);

        $this->value()->shouldReturn(Limit::UNLIMITED);
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
