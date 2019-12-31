<?php

namespace spec\Distil\Stubs;

use Distil\Criteria;
use Distil\Criterion;
use Distil\Stubs\StringCriterionStub;
use Distil\Types\StringCriterion;
use PhpSpec\ObjectBehavior;

class StringCriterionStubSpec extends ObjectBehavior
{
    private const VALUE = 'Some String Value';

    public function let(): void
    {
        $this->beConstructedWith(self::VALUE);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(StringCriterion::class);
        $this->shouldHaveType(Criterion::class);
    }

    public function it_can_return_its_name(): void
    {
        $this->name()->shouldReturn(StringCriterionStub::NAME);
    }

    public function it_can_return_its_value(): void
    {
        $this->value()->shouldReturn(self::VALUE);
    }

    public function it_can_be_casted_to_a_string(): void
    {
        $this->__toString()->shouldReturn(self::VALUE);
    }

    public function it_can_act_as_criteria_factory(): void
    {
        $criteria = $this::criteria(self::VALUE);

        $criteria->shouldReturnAnInstanceOf(Criteria::class);
        $criteria->get(StringCriterionStub::NAME)->value()->shouldReturn(self::VALUE);
    }
}
