<?php

namespace Fixtures\BeatSwitch\Distil\Criteria;

use BeatSwitch\Distil\Criteria\Criterion;
use BeatSwitch\Distil\Criteria\Keywords\Keywordable;

final class KeywordableCriterion implements Criterion, Keywordable
{
    const KEYWORD = 'keyword';

    public function name(): string
    {
        return 'keywordable';
    }

    public function value()
    {
        return 'Some Value';
    }

    public static function keywords(): array
    {
        return [self::KEYWORD => null];
    }
}
