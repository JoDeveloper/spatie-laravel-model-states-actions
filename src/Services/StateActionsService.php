<?php

namespace Abather\SpatieLaravelModelStatesActions\Services;

use App\Traits\Makeable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class StateActionsService
{
    use Makeable;

    /** @var Model::class */
    private string $model;

    private string $field;

    private ?User $user;

    private array $excluded_states = [];

    private array $include_states = [];

    public function __construct(string $model, string $field = 'state', ?User $user = null)
    {
        $this->model = $model;
        $this->field = $field;
        $this->user = $user ?? auth()->user();
    }

    public function excludeStates(array|string $excluded_states): self
    {
        if (is_string($excluded_states)) {
            $excluded_states = [$excluded_states];
        }

        $this->excluded_states = array_merge($this->excluded_states, $excluded_states);

        return $this;
    }

    public function includeStates(array|string $include_states): self
    {
        if (is_string($include_states)) {
            $include_states = [$include_states];
        }

        $this->include_states = array_merge($this->include_states, $include_states);

        return $this;
    }

    private function getStates(): array
    {
        return array_diff($this->model::getStatesFor($this->field)->toArray(), $this->excluded_states);
    }

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
}
