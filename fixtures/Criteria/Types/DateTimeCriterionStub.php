<?php

namespace Fixtures\BeatSwitch\Distil\Criteria\Types;

use BeatSwitch\Distil\Criteria\Types\DateTimeCriterion;

final class DateTimeCriterionStub extends DateTimeCriterion
{
    const NAME = 'date_time_stub';

    public function name(): string
    {
        return self::NAME;
    }
}
