<?php

declare(strict_types=1);

use App\Models\User;

test('appearance settings page is displayed', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->visit(route('appearance.edit', absolute: false))
        ->assertNoJavaScriptErrors()
        ->assertSee('Appearance settings');
});

test('appearance page renders in dark mode without errors', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->visit(route('appearance.edit', absolute: false))
        ->inDarkMode()
        ->assertNoJavaScriptErrors()
        ->assertSee('Appearance settings');
});
