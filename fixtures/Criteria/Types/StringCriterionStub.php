<?php

namespace Fixtures\BeatSwitch\Distil\Criteria\Types;

use BeatSwitch\Distil\Criteria\Types\StringCriterion;

final class StringCriterionStub extends StringCriterion
{
    const NAME = 'string_stub';

    public function name(): string
    {
        return self::NAME;
    }
}
