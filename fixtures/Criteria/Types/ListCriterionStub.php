<?php

namespace Fixtures\BeatSwitch\Distil\Criteria\Types;

use BeatSwitch\Distil\Criteria\Types\ListCriterion;

final class ListCriterionStub extends ListCriterion
{
    const NAME = 'list_stub';

    public function name(): string
    {
        return self::NAME;
    }
}
