<?php

namespace BeatSwitch\Distil\Criteria\Common;

use BeatSwitch\Distil\Criteria\Exceptions\InvalidLimit;
use BeatSwitch\Distil\Criteria\Keywords\Keywordable;
use BeatSwitch\Distil\Criteria\Types\IntegerCriterion;

final class Limit extends IntegerCriterion implements Keywordable
{
    const NAME = 'limit';

    const ALL = null;
    const ALL_KEYWORD = 'all';
    const DEFAULT = 10;

    public function __construct(?int $value = self::DEFAULT)
    {
        if ($value === 0) {
            throw InvalidLimit::cannotBeZero();
        }

        parent::__construct($value);
    }

    public function name(): string
    {
        return self::NAME;
    }

    public function isUnlimited(): bool
    {
        return $this->value() === self::ALL;
    }

    public static function keywords(): array
    {
        return [self::ALL_KEYWORD => self::ALL];
    }
}
