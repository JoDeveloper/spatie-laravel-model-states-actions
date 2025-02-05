<?php

namespace Abather\SpatieLaravelModelStatesActions\Services;

use Abather\SpatieLaravelModelStatesActions\Traits\Makeable;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;

class _BaseService
{
    use Makeable;

    /** @var Model::class */
    protected string $model;

    protected string $field;

    protected ?User $user;

    protected array $excluded_states = [];

    protected array $include_states = [];

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

    protected function getStates(): array
    {
        return array_diff($this->model::getStatesFor($this->field)->toArray(), $this->excluded_states);
    }
}