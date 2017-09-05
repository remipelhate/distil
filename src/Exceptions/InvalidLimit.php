<?php

namespace BeatSwitch\Distil\Exceptions;

use Exception;

final class InvalidLimit extends Exception
{
    public static function cannotBeZero(): self
    {
        return new self('The limit cannot be 0.');
    }
}
