<?php

namespace BeatSwitch\Distil;

use ArrayAccess;
use BeatSwitch\Distil\Criteria\Criterion;
use BeatSwitch\Distil\Exceptions\CannotAddCriterion;

final class Criteria implements ArrayAccess
{
    /**
     * @var Criterion[]
     */
    private $items = [];

    public function __construct(Criterion ...$items)
    {
        foreach ($items as $criterion) {
            $this->add($criterion);
        }
    }

    /**
     * @return Criterion[]
     */
    public function all(): array
    {
        return $this->items;
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    public function has(string $name): bool
    {
        return array_key_exists($name, $this->items);
    }

    public function get(string $name): ?Criterion
    {
        return $this->items[$name] ?? null;
    }

    public function add(Criterion $criterion): self
    {
        if (array_key_exists($criterion->name(), $this->items)) {
            throw CannotAddCriterion::nameAlreadyTaken($criterion);
        }

        return $this->set($criterion);
    }

    public function set(Criterion $criterion): self
    {
        $this->items[$criterion->name()] = $criterion;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset): Criterion
    {
        return $this->items[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if (! $value instanceof Criterion) {
            throw CannotAddCriterion::notACriterionInstance();
        }

        $this->set($value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }
}
