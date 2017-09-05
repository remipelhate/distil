<?php

namespace Fixtures\BeatSwitch\Distil\Types;

use BeatSwitch\Distil\Types\IntegerCriterion;

final class IntegerCriterionStub extends IntegerCriterion
{
    const NAME = 'integer_stub';

    public function name(): string
    {
        return self::NAME;
    }
}
