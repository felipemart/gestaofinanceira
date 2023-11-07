<?php

namespace App\Livewire\Auth\Password;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\{DB, Hash, Password};
use Illuminate\Support\Str;
use Livewire\Attributes\{Rule};
use Livewire\Component;

class Reset extends Component
{
    public ?string $token = null;

    #[Rule('required', message: 'Por favor digite um email')]
    #[Rule('email', message: 'Por favor digite um email valido')]
    #[Rule('confirmed', message: 'Por favor email de confirmação não confere com email informado')]
    public ?string $email = null;

    public ?string $email_confirmation = null;

    #[Rule('required', message: 'Por favor digite uma senha')]
    #[Rule('confirmed', message: 'Por favor confirme a senha')]
    public ?string $password = null;

    public ?string $password_confirmation = null;

    public function mount(?string $token = null, ?string $email = null): void
    {
        $this->token = request('token', $token);
        $this->email = request('email', $email);

        if($this->tokenNotValid()) {
            session()->flash('status', 'Token invalido');
            $this->redirectRoute('login');
        }

    }

    public function updatePassword(): void
    {

        $this->validate();

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, $password) {

                $user->password       = $password;
                $user->remember_token = Str::random(60);
                $user->save();

                event(new PasswordReset($user));
            }
        );

        session()->flash('status', __($status));
        $this->redirectRoute('dashboard');
    }

    public function render(): View
    {
        return view('livewire.auth.password.reset')
            ->layout('components.layouts.guest');
    }

    private function tokenNotValid(): bool
    {
        $tokens = DB::table('password_reset_tokens')->get('token');

        foreach ($tokens as $t) {
            if(Hash::check($this->token, $t->token)) {
                return  false;
            }
        }

        return true;

    }
}
