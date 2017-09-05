<?php

namespace BeatSwitch\Distil;

interface Criterion
{
    public function name(): string;

    public function value();
}
