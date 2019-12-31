<?php

namespace spec\Distil\Stubs;

use Distil\Criteria;
use Distil\Criterion;
use Distil\Exceptions\InvalidCriterionValue;
use Distil\Stubs\DateTimeCriterionStub;
use Distil\Types\DateTimeCriterion;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use PhpSpec\ObjectBehavior;

class DateTimeCriterionStubSpec extends ObjectBehavior
{
    private const VALUE = '2017-07-28T19:30:00+00:00';

    public function let(): void
    {
        $this->beConstructedWith(new DateTimeImmutable(self::VALUE));
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(DateTimeCriterion::class);
        $this->shouldHaveType(Criterion::class);
    }

    public function it_can_return_its_name(): void
    {
        $this->name()->shouldReturn(DateTimeCriterionStub::NAME);
    }

    public function it_can_return_its_value(): void
    {
        $this->value()->shouldBeLike(new DateTimeImmutable(self::VALUE));
    }

    public function it_can_return_its_default_format(): void
    {
        $this->format()->shouldReturn(DateTime::ATOM);
    }

    public function it_can_be_created_with_a_format(): void
    {
        $this->beConstructedWith(new DateTimeImmutable(self::VALUE), DateTime::RSS);

        $this->format()->shouldReturn(DateTime::RSS);
    }

    public function it_can_be_created_from_a_string_with_a_valid_datetime_value(): void
    {
        $this->beConstructedThrough('fromString', [self::VALUE]);

        $this->value()->shouldReturnAnInstanceOf(DateTimeInterface::class);
    }

    public function it_cannot_be_created_from_a_string_with_a_non_numeric_value(): void
    {
        $this->beConstructedThrough('fromString', ['rubbish']);

        $this->shouldThrow(InvalidCriterionValue::class)->duringInstantiation();
    }

    public function it_can_be_casted_to_a_string(): void
    {
        $this->__toString()->shouldReturn(self::VALUE);
    }

    public function it_can_act_as_criteria_factory(): void
    {
        $value = new DateTimeImmutable(self::VALUE);
        $criteria = $this::criteria($value);

        $criteria->shouldBeAnInstanceOf(Criteria::class);
        $criteria[DateTimeCriterionStub::NAME]->value()->shouldReturn($value);
    }
}
