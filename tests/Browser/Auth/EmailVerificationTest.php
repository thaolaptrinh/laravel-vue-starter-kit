<?php

declare(strict_types=1);

use App\Models\User;
use Laravel\Fortify\Features;

beforeEach(function (): void {
    $this->skipUnlessFortifyHas(Features::emailVerification());
});

test('email verification screen can be rendered', function (): void {
    $user = User::factory()->unverified()->create();

    $this->actingAs($user)
        ->visit(route('verification.notice', absolute: false))
        ->assertNoJavaScriptErrors()
        ->assertSee('Resend verification email');
});

test('verification link can be re-requested', function (): void {
    $user = User::factory()->unverified()->create();

    $this->actingAs($user)
        ->visit(route('verification.notice', absolute: false))
        ->press('Resend verification email')
        ->wait(1)
        ->assertSee('A new verification link has been sent');
});
