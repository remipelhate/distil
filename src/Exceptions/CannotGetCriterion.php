<?php

declare(strict_types=1);

namespace Distil\Exceptions;

use Distil\Criteria;
use Exception;

final class CannotGetCriterion extends Exception
{
    public static function noItemForName(string $name): self
    {
        return new self(Criteria::class." does not contain an item named [{$name}].");
    }
}
