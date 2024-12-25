<?php

namespace Abather\SpatieLaravelModelStatesActions\Services;

use Abather\SpatieLaravelModelStatesActions\Traits\Makeable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class ChangStateService
{
    use Makeable;

    private ?string $ability = null;

    private User $user;

    private string $to;

    private string $attribute = 'state';

    private bool $skip_authorization = false;

    public function __construct(private Model $model, ?User $user = null)
    {
        $this->user = $user ?? auth()->user();
    }

    public function to(string $state)
    {
        $this->to = $state;

        $this->authorized();

        $this->model->{$this->attribute}->transitionTo($this->to);
    }

    public function attribute(string $attribute = 'state'): static
    {
        $this->attribute = $attribute;

        return $this;
    }

    public function ability(string $ability): static
    {
        $this->ability = $ability;

        return $this;
    }

    public function getAbility(): string
    {
        return $this->ability ?? $this->to::abilityName();
    }

    public function skipAuthorization(bool $skip_authorization = true): static
    {
        $this->skip_authorization = $skip_authorization;

        return $this;
    }

    public function isAuthorizationSkipped(): bool
    {
        return $this->skip_authorization;
    }

    private function authorized()
    {
        abort_unless($this->model->{$this->attribute}->canTransitionTo($this->to), 403);

        if ($this->isAuthorizationSkipped()) {
            return;
        }

        abort_unless($this->user->can($this->getAbility(), $this->model), 403);
    }
}
