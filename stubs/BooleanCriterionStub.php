<?php

namespace Stubs\BeatSwitch\Distil;

use BeatSwitch\Distil\Types\BooleanCriterion;

final class BooleanCriterionStub extends BooleanCriterion
{
    const NAME = 'boolean_stub';

    public function name(): string
    {
        return self::NAME;
    }
}
