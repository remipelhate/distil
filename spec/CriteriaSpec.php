<?php

namespace spec\BeatSwitch\Distil;

use ArrayAccess;
use BeatSwitch\Distil\Criteria;
use BeatSwitch\Distil\Criterion;
use BeatSwitch\Distil\Exceptions\CannotAddCriterion;
use PhpSpec\ObjectBehavior;

class CriteriaSpec extends ObjectBehavior
{
    private const CRITERION_NAME_FIRST = 'first';
    private const CRITERION_NAME_LAST = 'last';
    private const CRITERION_NAME_NEW = 'new';

    function let(Criterion $firstCriterion, Criterion $lastCriterion, Criterion $newCriterion)
    {
        $firstCriterion->name()->willReturn(self::CRITERION_NAME_FIRST);
        $lastCriterion->name()->willReturn(self::CRITERION_NAME_LAST);
        $newCriterion->name()->willReturn(self::CRITERION_NAME_NEW);

        $this->beConstructedWith($firstCriterion, $lastCriterion);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Criteria::class);
    }

    function it_can_be_created_without_criteria()
    {
        $this->beConstructedWith();

        $this->shouldHaveType(Criteria::class);
    }

    function it_can_return_all_of_its_criteria(Criterion $firstCriterion, Criterion $lastCriterion)
    {
        $this->all()->shouldReturn([
            self::CRITERION_NAME_FIRST => $firstCriterion,
            self::CRITERION_NAME_LAST => $lastCriterion,
        ]);
    }

    function it_returns_false_when_it_is_not_empty()
    {
        $this->isEmpty()->shouldReturn(false);
    }

    function it_returns_true_when_it_is_empty()
    {
        $this->beConstructedWith();

        $this->isEmpty()->shouldReturn(true);
    }

    function it_can_check_if_it_has_criteria_with_a_given_name()
    {
        $this->has(self::CRITERION_NAME_FIRST)->shouldReturn(true);
        $this->has('rubbish')->shouldReturn(false);
    }

    function it_can_get_a_criterion_by_name_if_it_exists(Criterion $firstCriterion)
    {
        $this->get(self::CRITERION_NAME_FIRST)->shouldReturn($firstCriterion);
    }

    function it_returns_null_when_there_is_no_criterion_for_the_given_name()
    {
        $this->get('rubbish')->shouldReturn(null);
    }

    function it_can_add_a_new_criterion(Criterion $newCriterion)
    {
        $this->add($newCriterion)->shouldReturnAnInstanceOf(Criteria::class);
        $this->has(self::CRITERION_NAME_NEW)->shouldReturn(true);
    }

    function it_cannot_add_a_new_criterion_when_the_name_is_already_taken(Criterion $firstCriterion)
    {
        $this->shouldThrow(CannotAddCriterion::class)->during('add', [$firstCriterion]);
    }

    function it_can_overwrite_a_criterion_by_name(Criterion $overwritingCriterion)
    {
        $overwritingCriterion->name()->willReturn(self::CRITERION_NAME_FIRST);

        $this->set($overwritingCriterion)->shouldReturnAnInstanceOf(Criteria::class);
        $this->get(self::CRITERION_NAME_FIRST)->shouldReturn($overwritingCriterion);
    }

    function it_can_be_used_as_an_array()
    {
        $this->shouldHaveType(ArrayAccess::class);
    }

    function it_can_check_if_it_has_criteria_through_array_access()
    {
        $this->offsetExists(self::CRITERION_NAME_FIRST)->shouldReturn(true);
        $this->offsetExists('rubbish')->shouldReturn(false);
    }

    function it_can_get_a_criterion_through_array_access(Criterion $firstCriterion)
    {
        $this->offsetGet(self::CRITERION_NAME_FIRST)->shouldReturn($firstCriterion);
    }

    function it_cannot_get_a_criterion_through_array_access_when_the_key_is_undefined()
    {
        $this->shouldThrow()->during('offsetGet', ['rubbish']);
    }

    function it_can_set_a_new_criterion_through_array_access(Criterion $newCriterion)
    {
        $this->offsetSet(null, $newCriterion);
        $this->has(self::CRITERION_NAME_NEW)->shouldReturn(true);
    }

    function it_always_uses_the_criterion_name_when_adding_criterion_through_array_access(Criterion $newCriterion)
    {
        $this->offsetSet('rubbish', $newCriterion);
        $this->has('rubbish')->shouldReturn(false);
        $this->has(self::CRITERION_NAME_NEW)->shouldReturn(true);
    }

    function it_can_overwrite_a_criterion_by_name_through_array_access(Criterion $overwritingCriterion)
    {
        $overwritingCriterion->name()->willReturn(self::CRITERION_NAME_FIRST);

        $this->offsetSet(null, $overwritingCriterion);
        $this->get(self::CRITERION_NAME_FIRST)->shouldReturn($overwritingCriterion);
    }
}
