<?php

namespace App\Livewire\Auth;

use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Support\Facades\{Auth};
use Livewire\Attributes\Rule;
use Livewire\Component;

class Login extends Component
{
    #[Rule('required', message: 'Por favor digite um email')]
    #[Rule('email', message: 'Por favor digite um email valido')]
    public ?string $email = null;

    #[Rule('required', message: 'Por favor digite uma senha')]
    public ?string $password = null;

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('components.layouts.guest');
    }

    public function tryLogin()
    {
        if(!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $this->addError('invalidCredentials', trans('auth.failed'));

            return;
        }

        $this->redirect(route('home'));

    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
