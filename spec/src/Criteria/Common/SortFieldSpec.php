<?php

namespace spec\src\BeatSwitch\Distil\Criteria\Common;

use BeatSwitch\Distil\Criteria\Common\SortField;
use PhpSpec\ObjectBehavior;

class SortFieldSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('foo.bar.baz', SortField::ASC);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SortField::class);
    }

    function it_can_return_its_name()
    {
        $this->name()->shouldReturn('baz');
    }

    function it_can_return_its_order()
    {
        $this->order()->shouldReturn(SortField::ASC);
    }

    function it_can_be_created_from_a_string()
    {
        $this->beConstructedThrough('fromString', ['-foo.bar.baz']);

        $this->shouldHaveType(SortField::class);
        $this->name()->shouldReturn('baz');
        $this->order()->shouldReturn(SortField::DESC);
    }

    function it_can_return_its_relations()
    {
        $this->relations()->shouldReturn(['foo', 'bar']);
    }

    function it_returns_an_empty_array_when_it_has_no_relations()
    {
        $this->beConstructedWith('foo', 'DESC');

        $this->relations()->shouldReturn([]);
    }

    function it_can_return_its_last_relation()
    {
        $this->lastRelation()->shouldReturn('bar');
    }

    function it_returns_an_empty_string_when_it_has_no_last_relation()
    {
        $this->beConstructedWith('foo', 'DESC');

        $this->lastRelation()->shouldReturn('');
    }

    function it_can_return_the_parent_of_a_relation()
    {
        $this->parentOf('bar')->shouldReturn('foo');
    }

    function it_returns_null_when_no_parent_was_found()
    {
        $this->parentOf('foo')->shouldReturn(null);
    }

    function it_can_check_whether_the_sort_field_belongs_to_a_relation()
    {
        $this->belongsToRelation()->shouldReturn(true);
    }
}
