<?php

namespace Distil\Stubs;

use Distil\Types\IntegerCriterion;

final class IntegerCriterionStub extends IntegerCriterion
{
    public const NAME = 'integer_stub';

    public function name(): string
    {
        return self::NAME;
    }
}
