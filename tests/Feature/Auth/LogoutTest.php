<?php

use App\Livewire\Logout;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

it('should be able to logout of the aplication', function () {
    $user = User::factory()->create();
    actingAs($user);

    Livewire::test(Logout::class)
        ->call('logout')
        ->assertRedirect(route('login'));

    expect(auth())
        ->guest()
        ->toBeTrue();

});
