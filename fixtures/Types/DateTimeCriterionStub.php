<?php

namespace Fixtures\BeatSwitch\Distil\Types;

use BeatSwitch\Distil\Types\DateTimeCriterion;

final class DateTimeCriterionStub extends DateTimeCriterion
{
    const NAME = 'date_time_stub';

    public function name(): string
    {
        return self::NAME;
    }
}