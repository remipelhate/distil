<?php

namespace Distil;

trait ActsAsCriteriaFactory
{
    public static function criteria(...$arguments): Criteria
    {
        return new Criteria(new static(...$arguments));
    }
}
