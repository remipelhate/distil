<?php

declare(strict_types=1);

namespace Distil\Exceptions;

use Distil\Values\BooleanKeyword;
use RuntimeException;

use function array_keys;
use function implode;

class InvalidKeyword extends RuntimeException
{
    public static function cannotBeCastedToBoolean(string $keyword): self
    {
        return new self(
            "[$keyword] is not a valid boolean keyword. Valid keywords are: ".
            implode(', ', array_keys(BooleanKeyword::CASTED_VALUES))
        );
    }
}
