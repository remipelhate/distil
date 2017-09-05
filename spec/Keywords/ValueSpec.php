<?php

namespace spec\Distil\Keywords;

use Distil\Criterion;
use Distil\Keywords\Value;
use Distil\Stubs\HasKeywordsCriterionStub;
use PhpSpec\ObjectBehavior;

class ValueSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new HasKeywordsCriterionStub(), null);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Value::class);
    }

    function it_can_return_the_keyword_associated_with_the_value()
    {
        $this->keyword()->shouldReturn(HasKeywordsCriterionStub::KEYWORD);
    }

    function it_returns_null_when_the_value_has_no_associated_keyword()
    {
        $this->beConstructedWith(new HasKeywordsCriterionStub(), 'foo');

        $this->keyword()->shouldReturn(null);
    }

    function it_returns_null_when_the_criterion_class_is_not_keywordable(Criterion $criterion)
    {
        $this->beConstructedWith($criterion, 'foo');

        $this->keyword()->shouldReturn(null);
    }
}
