<?php

namespace BeatSwitch\Distil\Exceptions;

use BeatSwitch\Distil\Types\ListCriterion;
use Exception;

final class InvalidCriterionValue extends Exception
{
    public static function expectedNumeric(string $criterionClass): self
    {
        return new self("The string value for $criterionClass should be numeric.");
    }

    public static function expectedTimeString(string $criterionClass): self
    {
        return new self("The string value for $criterionClass should be a valid time string.");
    }

    public static function expectedBoolean(string $criterionClass): self
    {
        return new self("The string value for $criterionClass should be a boolean.");
    }

    public static function mixedValueTypes(string $expected, string $unexpected): self
    {
        return new self(
            'Values contained by ['.ListCriterion::class.'] instances should all '.
            "be of the same type. Received both [$expected] and [$unexpected]."
        );
    }
}
