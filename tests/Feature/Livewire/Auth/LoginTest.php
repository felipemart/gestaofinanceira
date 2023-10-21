<?php

use App\Livewire\Auth\Login;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Livewire\Livewire;

use function Pest\Laravel\{assertDatabaseCount, assertDatabaseHas};

test('login screen can be rendered', function () {
    $response = $this->get('/login');
    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {

    User::factory()->create(['email' => 'joe@example.com', 'password' => '123456']);

    Livewire::test(Login::class)
        ->set('email', 'joe@example.com')
        ->set('password', '123456')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertRedirect(RouteServiceProvider::HOME);

    expect(auth()->check())
        ->and(auth()->user())
        ->id->toBe(User::first()->id);

});
