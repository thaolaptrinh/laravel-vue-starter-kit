<?php

declare(strict_types=1);

use App\Models\User;

test('login screen can be rendered', function (): void {
    $this->visit(route('login', absolute: false))
        ->assertNoJavaScriptErrors()
        ->assertSee('Log in');
});

test('users can authenticate using the login screen', function (): void {
    $user = User::factory()->create();

    $this->visit(route('login', absolute: false))
        ->type('email', $user->email)
        ->type('password', 'password')
        ->press('@login-button')
        ->wait(1)
        ->assertPathIs('/dashboard')
        ->assertNoJavaScriptErrors();
});

test('users can not authenticate with invalid password', function (): void {
    $user = User::factory()->create();

    $this->visit(route('login', absolute: false))
        ->type('email', $user->email)
        ->type('password', 'wrong-password')
        ->press('@login-button')
        ->wait(1)
        ->assertPathIs('/login')
        ->assertSee('These credentials do not match our records.');
});

test('users can logout', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->visit('/dashboard')
        ->wait(1)
        ->click('@sidebar-menu-button')
        ->wait(1)
        ->click('@logout-button')
        ->wait(2)
        ->assertPathIs('/')
        ->assertNoJavaScriptErrors();

    $this->assertGuest();
});

test('users can login with remember me', function (): void {
    $user = User::factory()->create(['remember_token' => null]);

    $this->visit(route('login', absolute: false))
        ->type('email', $user->email)
        ->type('password', 'password')
        ->check('remember')
        ->press('@login-button')
        ->wait(1)
        ->assertPathIs('/dashboard')
        ->assertNoJavaScriptErrors();

    expect($user->fresh()->remember_token)->not->toBeNull();
});
