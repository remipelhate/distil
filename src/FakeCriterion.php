<?php

declare(strict_types=1);

namespace Distil;

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

    public static function make(string $name, $value): self
    {
        return new self($name, $value);
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
