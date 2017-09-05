<?php

namespace Stubs\BeatSwitch\Distil;

use BeatSwitch\Distil\Types\StringCriterion;

final class StringCriterionStub extends StringCriterion
{
    const NAME = 'string_stub';

    public function name(): string
    {
        return self::NAME;
    }
}
