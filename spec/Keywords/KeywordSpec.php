<?php

namespace spec\Distil\Keywords;

use Distil\Criterion;
use Distil\Keywords\Keyword;
use Distil\Stubs\HasKeywordsCriterionStub;
use PhpSpec\ObjectBehavior;

class KeywordSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith(HasKeywordsCriterionStub::class, HasKeywordsCriterionStub::KEYWORD);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Keyword::class);
    }

    public function it_can_return_the_value_associated_with_the_keyword(): void
    {
        $this->value()->shouldReturn(null);
    }

    public function it_returns_the_keyword_as_value_when_it_has_no_associated_value(): void
    {
        $this->beConstructedWith(HasKeywordsCriterionStub::class, 'rubbish');

        $this->value()->shouldReturn('rubbish');
    }

    public function it_returns_the_keyword_as_value_when_the_criterion_class_is_not_keywordable(): void
    {
        $this->beConstructedWith(Criterion::class, 'foo');

        $this->value()->shouldReturn('foo');
    }
}
