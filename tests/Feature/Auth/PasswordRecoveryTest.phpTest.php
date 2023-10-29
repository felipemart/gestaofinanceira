<?php

use App\Livewire\Auth\Password\Recovery;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

use function Pest\Laravel\{assertDatabaseCount, assertDatabaseHas, get};

test('needs to have a route to password recovery', function () {

    get(route('password.recovery'))
        ->assertSeeLivewire('auth.password.recovery')
        ->assertOk();
});

it('should be able to request for a password recovery', function () {
    Notification::fake();
    $user = User::factory()->create();

    Livewire::test(Recovery::class)
        ->assertDontSee(trans('passwords.sent'))
        ->set('email', $user->email)
        ->call('startPasswordRecovery')
        ->assertSee(trans('passwords.sent'));

    Notification::assertSentTo($user, ResetPassword::class);
});

test('making sure the email is real email', function ($value, $rule) {
    Livewire::test(Recovery::class)
        ->set('email', $value)
        ->call('startPasswordRecovery')
        ->assertDontSee(trans('passwords.sent'))
        ->assertHasErrors(['email' => $rule]);
})->with([
    'required' => ['value' => '', 'rule' => 'required'],
    'email'    => ['value' => 'not-an-email', 'rule' => 'email'],
]);

test('needs to create a token when requesting for password recovery', function () {
    $user = User::factory()->create();

    Livewire::test(Recovery::class)
        ->set('email', $user->email)
        ->call('startPasswordRecovery');

    assertDatabaseCount('password_reset_tokens', count: 1);
    assertDatabaseHas('password_reset_tokens', ['email' => $user->email]);
});
