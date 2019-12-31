<?php

namespace spec\Distil\Common;

use Distil\Common\SortField;
use PhpSpec\ObjectBehavior;

class SortFieldSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('foo.bar.baz', SortField::ASC);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(SortField::class);
    }

    public function it_can_return_its_name(): void
    {
        $this->name()->shouldReturn('baz');
    }

    public function it_can_return_its_order(): void
    {
        $this->order()->shouldReturn(SortField::ASC);
    }

    public function it_can_be_created_from_a_string(): void
    {
        $this->beConstructedThrough('fromString', ['-foo.bar.baz']);

        $this->shouldHaveType(SortField::class);
        $this->name()->shouldReturn('baz');
        $this->order()->shouldReturn(SortField::DESC);
    }

    public function it_can_return_its_relations(): void
    {
        $this->relations()->shouldReturn(['foo', 'bar']);
    }

    public function it_returns_an_empty_array_when_it_has_no_relations(): void
    {
        $this->beConstructedWith('foo', 'DESC');

        $this->relations()->shouldReturn([]);
    }

    public function it_can_return_its_last_relation(): void
    {
        $this->lastRelation()->shouldReturn('bar');
    }

    public function it_returns_an_empty_string_when_it_has_no_last_relation(): void
    {
        $this->beConstructedWith('foo', 'DESC');

        $this->lastRelation()->shouldReturn('');
    }

    public function it_can_return_the_parent_of_a_relation(): void
    {
        $this->parentOf('bar')->shouldReturn('foo');
    }

    public function it_returns_null_when_no_parent_was_found(): void
    {
        $this->parentOf('foo')->shouldReturn(null);
    }

    public function it_can_check_whether_the_sort_field_belongs_to_a_relation(): void
    {
        $this->belongsToRelation()->shouldReturn(true);
    }
}
