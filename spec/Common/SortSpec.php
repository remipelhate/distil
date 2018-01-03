<?php

namespace spec\Distil\Common;

use Distil\Common\Sort;
use Distil\Common\SortField;
use Distil\Criteria;
use Distil\Types\ListCriterion;
use PhpSpec\ObjectBehavior;

class SortSpec extends ObjectBehavior
{
    private const SORT_FIELD_FOO = 'foo';
    private const SORT_FIELD_BAR = 'bar';
    private const VALUE = [
        self::SORT_FIELD_FOO,
        '-'.self::SORT_FIELD_BAR,
    ];

    function let()
    {
        $this->beConstructedWith(
            self::SORT_FIELD_FOO,
            '-'.self::SORT_FIELD_BAR
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Sort::class);
    }

    function it_extends_the_list_criterion()
    {
        $this->shouldHaveType(ListCriterion::class);
    }

    function it_can_return_its_value()
    {
        $this->value()->shouldReturn(self::VALUE);
    }

    function it_can_return_its_sort_fields()
    {
        $this->sortFields()->shouldBeLike([
            new SortField(self::SORT_FIELD_FOO, SortField::ASC),
            new SortField(self::SORT_FIELD_BAR, SortField::DESC),
        ]);
    }

    function it_can_be_casted_to_a_string()
    {
        $this->__toString()->shouldReturn('foo,-bar');
    }

    function it_can_be_created_from_a_string()
    {
        $this->beConstructedThrough('fromString', ['-foo,bar.baz']);

        $this->sortFields()->shouldBeLike([
            new SortField(self::SORT_FIELD_FOO, SortField::DESC),
            new SortField(self::SORT_FIELD_BAR.'.baz', SortField::ASC),
        ]);
    }

    function it_can_act_as_criteria_factory()
    {
        $criteria = $this::criteria(...self::VALUE);

        $criteria->shouldBeAnInstanceOf(Criteria::class);
        $criteria[Sort::NAME]->value()->shouldReturn(self::VALUE);
    }
}
