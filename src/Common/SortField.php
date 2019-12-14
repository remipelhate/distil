<?php

namespace Distil\Common;

final class SortField
{
    public const ASC = 'ASC';
    public const DESC = 'DESC';

    private string $name;
    private array $relations;
    private string $order;

    public function __construct(string $field, string $order)
    {
        $relations = explode('.', $field);

        $this->name = array_pop($relations);
        $this->relations = $relations;
        $this->order = $order;
    }

    public static function fromString(string $value): self
    {
        $valueParts = str_split($value);
        $order = self::ASC;

        if ($valueParts[0] === '-') {
            array_shift($valueParts);

            $order = self::DESC;
        }

        return new self(implode('', $valueParts), $order);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function relations(): array
    {
        return $this->relations;
    }

    public function nameWithRelations(): string
    {
        $fieldParts = $this->relations;
        $fieldParts[] = $this->name();

        return implode('.', $fieldParts);
    }

    public function lastRelation(): string
    {
        return end($this->relations);
    }

    public function belongsToRelation(): bool
    {
        return count($this->relations) > 0;
    }

    public function parentOf($relation): ?string
    {
        $index = array_search($relation, $this->relations);

        return $index > 0 ? $this->relations[$index - 1] : null;
    }

    public function order(): string
    {
        return $this->order;
    }

    public function __toString(): string
    {
        return $this->nameWithRelations();
    }
}
