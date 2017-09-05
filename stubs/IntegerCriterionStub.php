<?php

namespace Stubs\BeatSwitch\Distil;

use BeatSwitch\Distil\Types\IntegerCriterion;

final class IntegerCriterionStub extends IntegerCriterion
{
    const NAME = 'integer_stub';

    public function name(): string
    {
        return self::NAME;
    }
}
