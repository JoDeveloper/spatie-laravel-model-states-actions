<?php

namespace Abather\SpatieLaravelModelStatesActions\Services;

use Filament\Actions\ActionGroup;

class StateActionsService extends _BaseService
{
    public function tableActions(): array
    {
        $actions = [];

        foreach ($this->getStates() as $state) {
            if ($state::includeToActions() || in_array($state, $this->include_states)) {
                $actions[$this->getActionOrder($actions, $state::order())] = $state::tableAction($this->user);
            }
        }

        ksort($actions);

        return $actions;
    }

    private function getActionOrder(array $actions, int $order = 0): int
    {
        if (array_key_exists($order, $actions)) {
            return $this->getActionOrder($actions, $order + 1);
        }

        return $order;
    }

    public function actions(): array
    {

        $actions = [];

        foreach ($this->getStates() as $state) {
            if ($state::includeToActions() || in_array($state, $this->include_states)) {
                $actions[$this->getActionOrder($actions, $state::order())] = $state::action($this->user);
            }
        }

        ksort($actions);

        return $actions;
    }

    public function actionsAsGroup($record = null, $button = true): ActionGroup
    {
        return ActionGroup::make(
            $this->actions()
        )
            ->when($button, function ($component) {
                $component->button();
            })
            ->when($record, function ($component) use ($record) {
                $component->color(fn () => $record->importance->color())
                    ->label(fn () => $record->importance->label())
                    ->icon(fn () => $record->importance->icon());
            });
    }
}
