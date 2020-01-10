<?php

namespace Distil\Types;

use Distil\ActsAsCriteriaFactory;
use Distil\Criterion;
use Distil\Values\ConstructsFromInteger;

/**
 * @deprecated 1.0.0 Use the according traits instead.
 */
abstract class IntegerCriterion implements Criterion
{
    use ActsAsCriteriaFactory;
    use ConstructsFromInteger;
}
