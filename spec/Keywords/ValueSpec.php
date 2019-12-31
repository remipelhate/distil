<?php

namespace spec\Distil\Keywords;

use Distil\Criterion;
use Distil\Keywords\Value;
use Distil\Stubs\HasKeywordsCriterionStub;
use PhpSpec\ObjectBehavior;

class ValueSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith(new HasKeywordsCriterionStub(), null);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Value::class);
    }

    public function it_can_return_the_keyword_associated_with_the_value(): void
    {
        $this->keyword()->shouldReturn(HasKeywordsCriterionStub::KEYWORD);
    }

    public function it_returns_null_when_the_value_has_no_associated_keyword(): void
    {
        $this->beConstructedWith(new HasKeywordsCriterionStub(), 'foo');

        $this->keyword()->shouldReturn(null);
    }

    public function it_returns_null_when_the_criterion_class_is_not_keywordable(Criterion $criterion): void
    {
        $this->beConstructedWith($criterion, 'foo');

        $this->keyword()->shouldReturn(null);
    }
}
