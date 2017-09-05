<?php

namespace Distil\Exceptions;

use Distil\Criterion;
use Exception;

final class CannotCreateCriterion extends Exception
{
    public static function missingResolver(string $name, array $resolvableNames): self
    {
        return new self(
            "No resolver called [$name] was found to create an instance of ".Criterion::class.'.'.
            'The following resolvers are available: '.implode(', ', $resolvableNames)
        );
    }
}
