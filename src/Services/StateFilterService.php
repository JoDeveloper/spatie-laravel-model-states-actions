<?php

namespace Abather\SpatieLaravelModelStatesActions\Services;

use Abather\SpatieLaravelModelStatesActions\Traits\Makeable;

class StateFilterService extends _BaseService
{
    public function tableFilter(string $field = 'state', bool $multiple = true, ?string $label = null): SelectFilter
    {
        return SelectFilter::make($field)
            ->label($label ?? __($field))
            ->options($this->getOptions())
            ->multiple($multiple)
            ->attribute($field);
    }

    private function getOptions(): array
    {
        $result = [];

        foreach ($this->getStates() ?? [] as $option) {
            if ($option::includeToFilters() || in_array($option, $this->include_states)) {
                $result[$option] = $option::title();
            }
        }

        return $result;
    }
}