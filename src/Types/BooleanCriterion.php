<?php

namespace Distil\Types;

use Distil\ActsAsCriteriaFactory;
use Distil\Criterion;
use Distil\Values\CastsToBoolean;

/**
 * @deprecated 1.0.0 Use the according traits instead.
 */
abstract class BooleanCriterion implements Criterion
{
    use ActsAsCriteriaFactory;
    use CastsToBoolean;
}
