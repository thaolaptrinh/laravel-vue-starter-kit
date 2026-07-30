<?php

declare(strict_types=1);

use App\Models\User;

test('public pages render without javascript errors', function (): void {
    $this->visit(['/', '/login', '/register', '/forgot-password'])
        ->assertNoJavaScriptErrors()
        ->assertNoConsoleLogs();
});

test('authenticated pages render without javascript errors', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->visit(['/dashboard', '/settings/profile', '/settings/appearance'])
        ->assertNoJavaScriptErrors()
        ->assertNoConsoleLogs();
});
