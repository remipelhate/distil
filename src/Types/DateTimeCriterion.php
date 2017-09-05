<?php

namespace Distil\Types;

use Distil\Criterion;
use Distil\Exceptions\InvalidCriterionValue;
use Distil\Keywords\Keyword;
use Distil\Keywords\Value;
use Distil\OneOffCriteria;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;

abstract class DateTimeCriterion implements Criterion
{
    use OneOffCriteria;

    /**
     * @var DateTimeInterface
     */
    private $value;

    /**
     * @var string
     */
    private $format;

    public function __construct(DateTimeInterface $value, string $format = DateTime::ATOM)
    {
        $this->value = $value;
        $this->format = $format;
    }

    /**
     * @return static
     */
    public static function fromString(string $value, string $format = DateTime::ATOM): self
    {
        $value = (new Keyword(static::class, $value))->value();

        if ($value instanceof DateTimeInterface) {
            return new static($value, $format);
        } elseif (strtotime($value)) {
            return new static(new DateTimeImmutable($value), $format);
        }

        throw InvalidCriterionValue::expectedTimeString(static::class);
    }

    public function value(): DateTimeInterface
    {
        return $this->value;
    }

    public function format(): string
    {
        return $this->format;
    }

    public function __toString(): string
    {
        return (new Value($this, $this->value))->keyword() ?: $this->value->format($this->format);
    }
}
