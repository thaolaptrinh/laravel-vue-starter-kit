<?php

declare(strict_types=1);

use App\Models\User;
use Laravel\Fortify\Features;

beforeEach(function (): void {
    $this->skipUnlessFortifyHas(Features::twoFactorAuthentication());
});

test('users with two factor enabled are redirected to two factor challenge', function (): void {
    $user = User::factory()->withTwoFactor()->create();

    $this->visit(route('login', absolute: false))
        ->type('email', $user->email)
        ->type('password', 'password')
        ->press('@login-button')
        ->wait(1)
        ->assertPathIs('/two-factor-challenge')
        ->assertNoJavaScriptErrors();
});

test('users can complete the challenge with a recovery code', function (): void {
    $user = User::factory()->withTwoFactor()->create();

    $this->visit(route('login', absolute: false))
        ->type('email', $user->email)
        ->type('password', 'password')
        ->press('@login-button')
        ->wait(1)
        ->assertPathIs('/two-factor-challenge')
        ->click('login using a recovery code')
        ->type('recovery_code', 'recovery-code-1')
        ->press('Continue')
        ->wait(1)
        ->assertPathIs('/dashboard')
        ->assertNoJavaScriptErrors();
});
