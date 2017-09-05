<?php

namespace Distil\Keywords;

use Distil\Criterion;

final class Value
{
    /**
     * @var Criterion
     */
    private $criterion;

    /**
     * @var mixed
     */
    private $value;

    public function __construct(Criterion $criterion, $value)
    {
        $this->criterion = $criterion;
        $this->value = $value;
    }

    public function keyword(): ?string
    {
        if ($this->criterion instanceof Keywordable) {
            return array_search($this->value, $this->criterion->keywords()) ?: null;
        }

        return null;
    }
}
