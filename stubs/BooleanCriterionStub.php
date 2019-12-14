<?php

namespace Distil\Stubs;

use Distil\Types\BooleanCriterion;

final class BooleanCriterionStub extends BooleanCriterion
{
    public const NAME = 'boolean_stub';

    public function name(): string
    {
        return self::NAME;
    }
}
