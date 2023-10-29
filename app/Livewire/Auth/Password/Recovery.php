<?php

namespace App\Livewire\Auth\Password;

use App\Models\User;
use App\Notifications\PasswordRecoveryNotification;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Recovery extends Component
{
    public ?string $message = null;

    #[Rule('required', message: 'Por favor digite um email')]
    #[Rule('email', message: 'Por favor digite um email valido')]
    public ?string $email = null;

    public function render(): View
    {
        return view('livewire.auth.password.recovery')
            ->layout('components.layouts.guest');
    }

    public function startPasswordRecovery(): void
    {
        $this->validate();

        $user = User::whereEmail($this->email)->first();

        $user?->notify(new PasswordRecoveryNotification());
        $this->message = trans('passwords.sent');

    }
}
