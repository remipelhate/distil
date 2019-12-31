<?php

namespace spec\Distil;

use Distil\Criteria;
use Distil\Criterion;
use Distil\Exceptions\CannotAddCriterion;
use PhpSpec\ObjectBehavior;

class CriteriaSpec extends ObjectBehavior
{
    private const CRITERION_NAME_FIRST = 'first';
    private const CRITERION_NAME_LAST = 'last';
    private const CRITERION_NAME_NEW = 'new';

    public function let(Criterion $firstCriterion, Criterion $lastCriterion, Criterion $newCriterion): void
    {
        $firstCriterion->name()->willReturn(self::CRITERION_NAME_FIRST);
        $lastCriterion->name()->willReturn(self::CRITERION_NAME_LAST);
        $newCriterion->name()->willReturn(self::CRITERION_NAME_NEW);

        $this->beConstructedWith($firstCriterion, $lastCriterion);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Criteria::class);
    }

    public function it_can_be_created_without_criteria(): void
    {
        $this->beConstructedWith();

        $this->shouldHaveType(Criteria::class);
    }

    public function it_can_return_all_of_its_criteria(Criterion $firstCriterion, Criterion $lastCriterion): void
    {
        $this->all()->shouldReturn([
            self::CRITERION_NAME_FIRST => $firstCriterion,
            self::CRITERION_NAME_LAST => $lastCriterion,
        ]);
    }

    public function it_returns_false_when_it_is_not_empty(): void
    {
        $this->isEmpty()->shouldReturn(false);
    }

    public function it_returns_true_when_it_is_empty(): void
    {
        $this->beConstructedWith();

        $this->isEmpty()->shouldReturn(true);
    }

    public function it_can_check_if_it_has_criteria_with_a_given_name(): void
    {
        $this->has(self::CRITERION_NAME_FIRST)->shouldReturn(true);
        $this->has('rubbish')->shouldReturn(false);
    }

    public function it_can_get_a_criterion_by_name_if_it_exists(Criterion $firstCriterion): void
    {
        $this->get(self::CRITERION_NAME_FIRST)->shouldReturn($firstCriterion);
    }

    public function it_returns_null_when_there_is_no_criterion_for_the_given_name(): void
    {
        $this->get('rubbish')->shouldReturn(null);
    }

    public function it_can_add_a_new_criterion(Criterion $newCriterion): void
    {
        $this->add($newCriterion)->shouldReturnAnInstanceOf(Criteria::class);
        $this->has(self::CRITERION_NAME_NEW)->shouldReturn(true);
    }

    public function it_cannot_add_a_new_criterion_when_the_name_is_already_taken(Criterion $firstCriterion): void
    {
        $this->shouldThrow(CannotAddCriterion::class)->during('add', [$firstCriterion]);
    }

    public function it_can_overwrite_a_criterion_by_name(Criterion $overwritingCriterion): void
    {
        $overwritingCriterion->name()->willReturn(self::CRITERION_NAME_FIRST);

        $this->set($overwritingCriterion)->shouldReturnAnInstanceOf(Criteria::class);
        $this->get(self::CRITERION_NAME_FIRST)->shouldReturn($overwritingCriterion);
    }
}
