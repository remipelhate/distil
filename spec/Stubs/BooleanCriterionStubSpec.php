<?php

namespace spec\Distil\Stubs;

use Distil\Criteria;
use Distil\Criterion;
use Distil\Exceptions\InvalidCriterionValue;
use Distil\Keywords\HasKeywords;
use Distil\Stubs\BooleanCriterionStub;
use Distil\Types\BooleanCriterion;
use PhpSpec\ObjectBehavior;

class BooleanCriterionStubSpec extends ObjectBehavior
{
    private const VALUE = true;

    public function let(): void
    {
        $this->beConstructedWith(self::VALUE);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(BooleanCriterion::class);
        $this->shouldHaveType(Criterion::class);
        $this->shouldHaveType(HasKeywords::class);
    }

    public function it_can_return_its_name(): void
    {
        $this->name()->shouldReturn(BooleanCriterionStub::NAME);
    }

    public function it_can_return_its_value(): void
    {
        $this->value()->shouldReturn(self::VALUE);
    }

    public function it_can_check_if_it_is_truthy(): void
    {
        $this->isTruthy()->shouldReturn(true);
        $this->isFalsy()->shouldReturn(false);
    }

    public function it_can_check_if_it_is_falsy(): void
    {
        $this->beConstructedWith(false);

        $this->isTruthy()->shouldReturn(false);
        $this->isFalsy()->shouldReturn(true);
    }

    public function it_can_be_created_from_a_string_with_a_valid_truthy_value(): void
    {
        $this->beConstructedThrough('fromString', [BooleanCriterion::KEYWORD_TRUE]);

        $this->value()->shouldReturn(true);
    }

    public function it_can_be_created_from_a_string_with_a_valid_falsy_value(): void
    {
        $this->beConstructedThrough('fromString', [BooleanCriterion::KEYWORD_FALSE]);

        $this->value()->shouldReturn(false);
    }

    public function it_cannot_be_created_from_a_string_with_an_invalid_boolean_value(): void
    {
        $this->beConstructedThrough('fromString', ['1']);

        $this->shouldThrow(InvalidCriterionValue::class)->duringInstantiation();
    }

    public function it_can_be_casted_to_a_string(): void
    {
        $this->__toString()->shouldReturn(BooleanCriterion::KEYWORD_TRUE);
    }

    public function it_can_act_as_criteria_factory(): void
    {
        $criteria = $this::criteria(self::VALUE);

        $criteria->shouldBeAnInstanceOf(Criteria::class);
        $criteria[BooleanCriterionStub::NAME]->value()->shouldReturn(self::VALUE);
    }
}
