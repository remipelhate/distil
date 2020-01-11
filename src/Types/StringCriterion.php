<?php

namespace Distil\Types;

use Distil\ActsAsCriteriaFactory;
use Distil\Criterion;
use Distil\Values\ConstructsFromKeyword;

/**
 * @deprecated 1.0.0 Use the according traits instead.
 */
abstract class StringCriterion implements Criterion
{
    use ActsAsCriteriaFactory;
    use ConstructsFromKeyword;
}
