<?php

namespace App\Livewire\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\{Auth, RateLimiter};
use Illuminate\Support\Str;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Login extends Component
{
    #[Rule('required', message: 'Por favor digite um email')]
    #[Rule('email', message: 'Por favor digite um email valido')]
    public ?string $email = null;

    #[Rule('required', message: 'Por favor digite uma senha')]
    public ?string $password = null;

    public function render(): View
    {
        return view('livewire.auth.login')
            ->layout('components.layouts.guest');
    }

    public function tryLogin(): void
    {
        if(RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {

            $this->addError('rateLimiter', trans('auth.throttle', [
                'seconds' => RateLimiter::availableIn($this->throttleKey()),
            ]));

            return;

        }

        if(!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {

            RateLimiter::hit($this->throttleKey());

            $this->addError('invalidCredentials', trans('auth.failed'));

            return;
        }

        $this->redirect(route('home'));

    }

    /**
     * @return string
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}
