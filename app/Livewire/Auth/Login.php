<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Support\Facades\{Auth, Hash};
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

    public function submit()
    {
        $user = User::whereEmail($this->email)->first();

        if (Hash::check($this->password, $user->password)) {
            auth()->login($user);

            return to_route('home');
        }

        return to_route('auth.login');

    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
