<?php

namespace BeatSwitch\Distil\Criteria;

use BeatSwitch\Distil\Criteria;

trait OneOffCriteria
{
    public static function criteria(...$arguments): Criteria
    {
        return new Criteria(new static(...$arguments));
    }
}
