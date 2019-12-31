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

    public function let(): void
    {
        $this->beConstructedWith(
            self::SORT_FIELD_FOO,
            '-'.self::SORT_FIELD_BAR
        );
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Sort::class);
    }

    public function it_extends_the_list_criterion(): void
    {
        $this->shouldHaveType(ListCriterion::class);
    }

    public function it_can_return_its_value(): void
    {
        $this->value()->shouldReturn(self::VALUE);
    }

    public function it_can_return_its_sort_fields(): void
    {
        $this->sortFields()->shouldBeLike([
            new SortField(self::SORT_FIELD_FOO, SortField::ASC),
            new SortField(self::SORT_FIELD_BAR, SortField::DESC),
        ]);
    }

    public function it_can_be_casted_to_a_string(): void
    {
        $this->__toString()->shouldReturn('foo,-bar');
    }

    public function it_can_be_created_from_a_string(): void
    {
        $this->beConstructedThrough('fromString', ['-foo,bar.baz']);

        $this->sortFields()->shouldBeLike([
            new SortField(self::SORT_FIELD_FOO, SortField::DESC),
            new SortField(self::SORT_FIELD_BAR.'.baz', SortField::ASC),
        ]);
    }

    public function it_can_act_as_criteria_factory(): void
    {
        $criteria = $this::criteria(...self::VALUE);

        $criteria->shouldBeAnInstanceOf(Criteria::class);
        $criteria[Sort::NAME]->value()->shouldReturn(self::VALUE);
    }
}
