<?php

declare(strict_types=1);

use App\Models\User;
use Laravel\Fortify\Features;

beforeEach(function (): void {
    $this->skipUnlessFortifyHas(Features::registration());
});

test('registration screen can be rendered', function (): void {
    $this->visit(route('register', absolute: false))
        ->assertNoJavaScriptErrors()
        ->assertSee('Create account');
});

test('new users can register', function (): void {
    $this->visit(route('register', absolute: false))
        ->type('name', 'Test User')
        ->type('email', 'test@example.com')
        ->type('password', 'password')
        ->type('password_confirmation', 'password')
        ->press('@register-user-button')
        ->wait(1)
        ->assertPathIs('/dashboard')
        ->assertNoJavaScriptErrors();
});

test('registration requires matching passwords', function (): void {
    $this->visit(route('register', absolute: false))
        ->type('name', 'Test User')
        ->type('email', 'test@example.com')
        ->type('password', 'password')
        ->type('password_confirmation', 'wrong-password')
        ->press('@register-user-button')
        ->wait(1)
        ->assertPathIs('/register')
        ->assertSee('The password field confirmation does not match.');
});

test('registration requires a unique email', function (): void {
    $user = User::factory()->create();

    $this->visit(route('register', absolute: false))
        ->type('name', 'Test User')
        ->type('email', $user->email)
        ->type('password', 'password')
        ->type('password_confirmation', 'password')
        ->press('@register-user-button')
        ->wait(1)
        ->assertPathIs('/register')
        ->assertSee('The email has already been taken.');
});
