<?php

namespace Fixtures\BeatSwitch\Distil\Types;

use BeatSwitch\Distil\Types\BooleanCriterion;

final class BooleanCriterionStub extends BooleanCriterion
{
    const NAME = 'boolean_stub';

    public function name(): string
    {
        return self::NAME;
    }
}
