<?php

namespace Distil\Types;

use Distil\ActsAsCriteriaFactory;
use Distil\Criterion;
use Distil\Values\ConstructsFromDateTime;

/**
 * @deprecated 1.0.0 Use the according traits instead.
 */
abstract class DateTimeCriterion implements Criterion
{
    use ActsAsCriteriaFactory;
    use ConstructsFromDateTime;
}
