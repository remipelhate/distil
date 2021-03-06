<?php

namespace Distil\Exceptions;

use Distil\Criteria;
use Distil\Criterion;
use Exception;

final class CannotAddCriterion extends Exception
{
    public static function nameAlreadyTaken(Criterion $criterion): self
    {
        return new self(Criteria::class." already contains an item named [{$criterion->name()}].");
    }

    public static function notACriterionInstance(): self
    {
        return new self(Criteria::class.' can only contain instances of '.Criterion::class.'.');
    }
}
