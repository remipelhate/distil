<?php

namespace BeatSwitch\Distil\Criteria\Exceptions;

use BeatSwitch\Distil\Criteria\Criterion;
use Exception;

final class CannotCreateCriterion extends Exception
{
    public static function noResolverForName(string $name, array $resolvableNames): self
    {
        return new self(
            'Could create an instance of '.Criterion::class." as there is no resolver registered for name [$name]. ".
            'The following names can be resolved: '.implode(', ', $resolvableNames)
        );
    }
}
