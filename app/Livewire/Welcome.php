<?php

namespace App\Livewire;

use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Welcome extends Component
{
    public function render(): View
    {
        if (Auth::check()) {
            $this->redirect(RouteServiceProvider::HOME);
        }

        return view('livewire.welcome')
            ->layout('components.layouts.guest');
    }
}
