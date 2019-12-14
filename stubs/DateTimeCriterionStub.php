<?php

namespace Distil\Stubs;

use Distil\Types\DateTimeCriterion;

final class DateTimeCriterionStub extends DateTimeCriterion
{
    public const NAME = 'date_time_stub';

    public function name(): string
    {
        return self::NAME;
    }
}
