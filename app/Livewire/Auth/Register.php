<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Notifications\WelcomeNotification;
use App\Providers\RouteServiceProvider;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Register extends Component
{
    #[Rule('required', message: 'Por favor digite um nome')]
    #[Rule('max:255', message: 'Quantidade maxima 255 caracteres')]
    public ?string $name = null;

    #[Rule('required', message: 'Por favor digite um email')]
    #[Rule('email', message: 'Por favor digite um email valido')]
    #[Rule('max:255', message: 'Quantidade maxima 255 caracteres')]
    #[Rule('confirmed', message: 'Confirme o email')]
    #[Rule('unique:users,email', message: 'Ja existe este email cadastrado')]
    public ?string $email = null;

    public ?string $email_confirmation = null;

    #[Rule('required', message: 'Por favor digite uma senha')]
    public ?string $password = null;

    public function render()
    {
        return view('livewire.auth.register')
            ->layout('components.layouts.guest');
        ;
    }

    public function submit(): void
    {
        $this->validate();

        $user = User::query()->create([
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => $this->password,
        ]);

        auth()->login($user);

        //        $user->notify(new WelcomeNotification());

        $this->redirect(RouteServiceProvider::HOME);
    }
}
