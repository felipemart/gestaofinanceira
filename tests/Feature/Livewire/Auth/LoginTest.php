<?php

use App\Livewire\Auth\Login;
use App\Models\User;
use Livewire\Livewire;

it('login screen can be rendered', function () {
    Livewire::test(Login::class)
        ->assertOk();

});

it('users can authenticate using the login screen', function () {

    $user = User::factory()->create(['email' => 'joe@example.com', 'password' => '123456']);

    Livewire::test(Login::class)
        ->set('email', 'joe@example.com')
        ->set('password', '123456')
        ->call('tryLogin')
        ->assertHasNoErrors()
        ->assertRedirect(route('home'));

    expect(auth()->check())->toBeTrue()
        ->and(auth()->user())->id->toBe($user->id);

});

it('should make sure to inform the user an error when email and password doesnt work', function () {
    Livewire::test(Login::class)
        ->set('email', 'joe@example.com')
        ->set('password', '1234567')
        ->call('tryLogin')
        ->assertHasErrors(['invalidCredentials'])
        ->assertSee(trans('auth.failed'));
});

it('should make sure that the rate limit is blocking after 5 attempts', function () {

    $user = User::factory()->create(['email' => 'joe@example.com', 'password' => '123456']);

    for($i = 0; $i < 5; $i++) {
        Livewire::test(Login::class)
            ->set('email', 'joe@example')
            ->set('password', 'wrong-password')
            ->call('tryLogin')
            ->assertHasErrors(['invalidCredentials']);
    }

    Livewire::test(Login::class)
        ->set('email', 'joe@example')
        ->set('password', 'wrong-password')
        ->call('tryLogin')
        ->assertHasErrors(['rateLimiter']);

});
