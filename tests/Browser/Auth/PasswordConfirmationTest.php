<?php

declare(strict_types=1);

use App\Models\User;

test('confirm password screen can be rendered', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->visit(route('password.confirm', absolute: false))
        ->assertNoJavaScriptErrors()
        ->assertSee('Confirm password');
});

test('user can confirm their password', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->visit(route('password.confirm', absolute: false))
        ->type('password', 'password')
        ->press('@confirm-password-button')
        ->wait(1)
        ->assertNoJavaScriptErrors();
});
