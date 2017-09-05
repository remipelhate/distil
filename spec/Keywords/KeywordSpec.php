<?php

namespace spec\Distil\Keywords;

use Distil\Criterion;
use Distil\Keywords\Keyword;
use Distil\Stubs\HasKeywordsCriterionStub;
use PhpSpec\ObjectBehavior;

class KeywordSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(HasKeywordsCriterionStub::class, HasKeywordsCriterionStub::KEYWORD);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Keyword::class);
    }

    function it_can_return_the_value_associated_with_the_keyword()
    {
        $this->value()->shouldReturn(null);
    }

    function it_returns_the_keyword_as_value_when_it_has_no_associated_value()
    {
        $this->beConstructedWith(HasKeywordsCriterionStub::class, 'rubbish');

        $this->value()->shouldReturn('rubbish');
    }

    function it_returns_the_keyword_as_value_when_the_criterion_class_is_not_keywordable()
    {
        $this->beConstructedWith(Criterion::class, 'foo');

        $this->value()->shouldReturn('foo');
    }
}
