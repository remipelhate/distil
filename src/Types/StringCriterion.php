<?php

namespace Distil\Types;

use Distil\ActsAsCriteriaFactory;
use Distil\Criterion;
use Distil\Values\ConstructsFromKeyword;

abstract class StringCriterion implements Criterion
{
    use ActsAsCriteriaFactory;
    use ConstructsFromKeyword;
}
