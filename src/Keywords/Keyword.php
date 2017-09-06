<?php

namespace Distil\Keywords;

final class Keyword
{
    /**
     * @var string
     */
    private $keyword;

    /**
     * @var array
     */
    private $values;

    public function __construct(string $criterionClass, string $keyword)
    {
        $this->keyword = $keyword;
        $this->values = $this->hasKeywords($criterionClass) ? $criterionClass::keywords() : [];
    }

    private function hasKeywords(string $criterionClass): bool
    {
        $interfaces = class_implements($criterionClass) ?: [];

        return isset($interfaces[HasKeywords::class]);
    }

    public function value()
    {
        if (array_key_exists($this->keyword, $this->values)) {
            return $this->values[$this->keyword];
        }

        return $this->keyword;
    }
}
