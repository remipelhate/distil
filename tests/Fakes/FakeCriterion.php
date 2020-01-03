<?php

declare(strict_types=1);

namespace Distil\Tests\Fakes;

use Distil\ActsAsCriteriaFactory;
use Distil\Criterion;

final class FakeCriterion implements Criterion
{
    use ActsAsCriteriaFactory;

    private string $name;

    /**
     * @var mixed
     */
    private $value;

    public function __construct(string $name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function value()
    {
        return $this->value;
    }
}
