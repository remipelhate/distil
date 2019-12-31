<?php

namespace spec\Distil\Common;

use Distil\Common\Limit;
use Distil\Criteria;
use Distil\Exceptions\InvalidCriterionValue;
use Distil\Exceptions\InvalidLimit;
use Distil\Keywords\HasKeywords;
use PhpSpec\ObjectBehavior;

class LimitSpec extends ObjectBehavior
{
    private const VALUE = 6;

    public function let(): void
    {
        $this->beConstructedWith(self::VALUE);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Limit::class);
    }

    public function it_has_keywords(): void
    {
        $this->shouldHaveType(HasKeywords::class);
    }

    public function it_cannot_be_created_with_a_zero_value(): void
    {
        $this->beConstructedWith(0);

        $this->shouldThrow(InvalidLimit::class)->duringInstantiation();
    }

    public function it_can_be_created_without_a_limit_value(): void
    {
        $this->beConstructedWith(null);
    }

    public function it_can_return_its_name(): void
    {
        $this->name()->shouldReturn(Limit::NAME);
    }

    public function it_can_return_its_value(): void
    {
        $this->value()->shouldReturn(self::VALUE);
    }

    public function it_can_be_created_from_a_string(): void
    {
        $this->beConstructedThrough('fromString', [(string) self::VALUE]);

        $this->value()->shouldReturn(self::VALUE);
    }

    public function it_cannot_be_created_from_a_string_with_an_invalid_keyword(): void
    {
        $this->beConstructedThrough('fromString', ['rubbish']);

        $this->shouldThrow(InvalidCriterionValue::class)->duringInstantiation();
    }

    public function it_can_be_created_from_a_string_with_the_all_keyword(): void
    {
        $this->beConstructedThrough('fromString', [Limit::KEYWORD_UNLIMITED]);

        $this->value()->shouldReturn(Limit::UNLIMITED);
    }

    public function it_is_not_unlimited_when_it_has_a_numeric_value(): void
    {
        $this->isUnlimited()->shouldReturn(false);
    }

    public function it_is_unlimited_when_it_has_a_null_value(): void
    {
        $this->beConstructedWith(null);

        $this->isUnlimited()->shouldReturn(true);
    }

    public function it_can_act_as_criteria_factory(): void
    {
        $criteria = $this::criteria(self::VALUE);

        $criteria->shouldBeAnInstanceOf(Criteria::class);
        $criteria[Limit::NAME]->value()->shouldReturn(self::VALUE);
    }
}
