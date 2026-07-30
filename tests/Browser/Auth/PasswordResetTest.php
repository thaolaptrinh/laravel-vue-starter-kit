<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Laravel\Fortify\Features;

beforeEach(function (): void {
    $this->skipUnlessFortifyHas(Features::resetPasswords());
});

test('reset password link screen can be rendered', function (): void {
    $this->visit(route('password.request', absolute: false))
        ->assertNoJavaScriptErrors()
        ->assertSee('Email password reset link');
});

test('reset password link can be requested', function (): void {
    Notification::fake();

    $user = User::factory()->create();

    $this->visit(route('password.request', absolute: false))
        ->type('email', $user->email)
        ->press('@email-password-reset-link-button')
        ->wait(1);

    Notification::assertSentTo($user, ResetPassword::class);
});

test('password can be reset with valid token', function (): void {
    Notification::fake();

    $user = User::factory()->create();

    $this->visit(route('password.request', absolute: false))
        ->type('email', $user->email)
        ->press('@email-password-reset-link-button')
        ->wait(1);

    $token = null;

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use (&$token): true {
        $token = $notification->token;

        return true;
    });

    $this->visit(route('password.reset', ['token' => $token, 'email' => $user->email], absolute: false))
        ->assertSee('Reset password')
        ->type('password', 'new-password')
        ->type('password_confirmation', 'new-password')
        ->press('@reset-password-button')
        ->wait(1)
        ->assertPathIs('/login')
        ->assertNoJavaScriptErrors();
});

test('password cannot be reset with invalid token', function (): void {
    $user = User::factory()->create();

    $this->visit(route('password.reset', ['token' => 'invalid-token', 'email' => $user->email], absolute: false))
        ->assertSee('Reset password')
        ->type('password', 'new-password')
        ->type('password_confirmation', 'new-password')
        ->press('@reset-password-button')
        ->wait(1)
        ->assertSee('This password reset token is invalid.');
});
