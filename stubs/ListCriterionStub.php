<?php

namespace Distil\Stubs;

use Distil\Types\ListCriterion;

final class ListCriterionStub extends ListCriterion
{
    public const NAME = 'list_stub';

    public function name(): string
    {
        return self::NAME;
    }
}
