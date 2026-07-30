<?php

declare(strict_types=1);

use App\Models\User;

test('security page requires password confirmation when enabled', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->visit(route('security.edit', absolute: false))
        ->wait(1)
        ->assertPathIs('/user/confirm-password');
});

test('password can be updated after confirming', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->visit(route('security.edit', absolute: false))
        ->wait(1)
        ->assertPathIs('/user/confirm-password')
        ->type('password', 'password')
        ->press('@confirm-password-button')
        ->wait(1)
        ->assertPathIs('/settings/security')
        ->type('current_password', 'password')
        ->type('password', 'new-password')
        ->type('password_confirmation', 'new-password')
        ->press('@update-password-button')
        ->wait(1)
        ->assertPathIs('/settings/security')
        ->assertNoJavaScriptErrors();
});
