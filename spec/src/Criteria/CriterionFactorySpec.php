<?php

namespace spec\src\BeatSwitch\Distil\Criteria;

use BeatSwitch\Distil\Criteria\Criterion;
use BeatSwitch\Distil\Criteria\CriterionFactory;
use BeatSwitch\Distil\Criteria\Exceptions\CannotCreateCriterion;
use PhpSpec\ObjectBehavior;

class CriterionFactorySpec extends ObjectBehavior
{
    private const NAME = 'stub';
    private const VALUE = 'Some Value';

    function it_is_initializable()
    {
        $this->shouldHaveType(CriterionFactory::class);
    }

    function it_cannot_create_a_criterion_instance_by_name_when_the_name_has_no_resolver()
    {
        $this->shouldThrow(CannotCreateCriterion::class)->during('createByName', ['rubbish']);
    }

    function it_can_create_a_criterion_instance_by_name_using_the_criterion_constructor()
    {
        $this->beConstructedWith([self::NAME => CriterionForFactory::class]);

        $criterion = $this->createByName(self::NAME, self::VALUE);

        $criterion->shouldReturnAnInstanceOf(CriterionForFactory::class);
        $criterion->value()->shouldReturn(self::VALUE);
        $criterion->otherValue()->shouldReturn(null);
    }

    function it_can_create_a_criterion_instance_by_name_using_a_callable_resolver()
    {
        $this->beConstructedWith([self::NAME => CriterionForFactory::class.'::resolve']);
        $otherValue = 'Some Other Value';

        $criterion = $this->createByName(self::NAME, self::VALUE, $otherValue);

        $criterion->shouldReturnAnInstanceOf(CriterionForFactory::class);

        // The resolver should reverse the received arguments to clearly indicate it both received
        // all required arguments and handled them differently than the default constructor.
        $criterion->value()->shouldReturn($otherValue);
        $criterion->otherValue()->shouldReturn(self::VALUE);
    }
}

final class CriterionForFactory implements Criterion
{
    public function __construct($value, $otherValue = null)
    {
        $this->value = $value;
        $this->otherValue = $otherValue;
    }

    public static function resolve(...$arguments): self
    {
        return new self(...array_reverse($arguments));
    }

    public function value()
    {
        return $this->value;
    }

    public function otherValue()
    {
        return $this->otherValue;
    }

    public function name(): string
    {
        return 'stub';
    }
}
