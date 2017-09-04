<?php

namespace BeatSwitch\Distil\Criteria;

interface Criterion
{
    public function name(): string;

    public function value();
}
