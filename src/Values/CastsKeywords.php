<?php

namespace Distil\Values;

trait CastsKeywords
{
    private ?Keyword $keyword = null;

    public function __toString(): string
    {
        if ($this->keyword) {
            return (string) $this->keyword;
        }

        return $this->value;
    }

    public static function fromKeyword(Keyword $keyword): self
    {
        $instance = new static($keyword->castedValue());
        $instance->keyword = $keyword;

        return $instance;
    }

    public function keyword(): ?Keyword
    {
        return $this->keyword;
    }
}
