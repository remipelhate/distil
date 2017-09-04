<?php

namespace Fixtures\BeatSwitch\Distil\Criteria\Types;

use BeatSwitch\Distil\Criteria\Types\BooleanCriterion;

final class BooleanCriterionStub extends BooleanCriterion
{
    const NAME = 'boolean_stub';

    public function name(): string
    {
        return self::NAME;
    }
}
