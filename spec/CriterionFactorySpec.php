<?php

namespace spec\Distil;

use Distil\Criterion;
use Distil\CriterionFactory;
use Distil\Exceptions\CannotCreateCriterion;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;

class CriterionFactorySpec extends ObjectBehavior
{
    private const NAME = 'stub';
    private const VALUE = 'Some Value';

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(CriterionFactory::class);
    }

    public function it_cannot_create_a_criterion_instance_by_name_when_the_name_has_no_resolver(): void
    {
        $this->shouldThrow(CannotCreateCriterion::class)->during('createByName', ['rubbish']);
    }

    public function it_fails_to_construct_with_resolvers_that_are_not_callable_or_a_class_name(): void
    {
        $this->beConstructedWith([self::NAME => 'rubbish']);

        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    public function it_can_create_a_criterion_instance_by_name_using_the_criterion_constructor(): void
    {
        $this->beConstructedWith([self::NAME => CriterionForFactory::class]);

        $criterion = $this->createByName(self::NAME, self::VALUE);

        $criterion->shouldReturnAnInstanceOf(CriterionForFactory::class);
        $criterion->value()->shouldReturn(self::VALUE);
        $criterion->otherValue()->shouldReturn(null);
    }

    public function it_can_create_a_criterion_instance_by_name_using_a_callable_string_resolver(): void
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

    public function it_can_create_a_criterion_instance_by_name_using_a_callable_resolver(): void
    {
        $this->beConstructedWith([self::NAME => function (...$arguments) {
            return new CriterionForFactory(...array_reverse($arguments));
        }]);
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
