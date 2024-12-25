<?php

namespace Abather\SpatieLaravelModelStatesActions\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Abather\SpatieLaravelModelStatesActions\SpatieLaravelModelStatesActions
 */
class SpatieLaravelModelStatesActions extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Abather\SpatieLaravelModelStatesActions\SpatieLaravelModelStatesActions::class;
    }
}
