<?php

namespace Abather\SpatieLaravelModelStatesActions\Traits;

trait Makeable
{
    public static function make(...$attributes): static
    {
        return new static(...$attributes);
    }
}