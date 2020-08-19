<?php

namespace Distil\Types;

use DateTimeInterface;
use Distil\ActsAsCriteriaFactory;
use Distil\Criterion;
use Distil\Values\ConstructsFromKeyword;
use Distil\Values\DateTimeKeyword;

abstract class DateTimeCriterion implements Criterion
{
    use ActsAsCriteriaFactory;
    use ConstructsFromKeyword;

    private DateTimeInterface $value;
    private string $format;

    public function __construct(DateTimeInterface $value, string $format = DateTimeInterface::ATOM)
    {
        $this->value = $value;
        $this->format = $format;
    }

    public function __toString(): string
    {
        if ($this->keyword) {
            return (string) $this->keyword;
        }

        return $this->value->format($this->format);
    }

    /**
     * @return static
     */
    public static function fromString(string $value): self
    {
        return self::fromKeyword(new DateTimeKeyword($value));
    }

    public function value(): DateTimeInterface
    {
        return $this->value;
    }

    public function format(): string
    {
        return $this->format;
    }
}
