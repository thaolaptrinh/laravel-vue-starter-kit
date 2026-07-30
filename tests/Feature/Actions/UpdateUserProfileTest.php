<?php

declare(strict_types=1);

use App\Actions\UpdateUserProfile;
use App\Models\User;

test('updates the user profile name and email', function (): void {
    $user = User::factory()->create();

    resolve(UpdateUserProfile::class)->handle($user, [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
    ]);

    $user->refresh();

    expect($user->name)->toBe('Jane Doe')
        ->and($user->email)->toBe('jane@example.com');
});

test('resets email verification when the email address changes', function (): void {
    $user = User::factory()->create(['email_verified_at' => now()]);

    resolve(UpdateUserProfile::class)->handle($user, [
        'name' => $user->name,
        'email' => 'new@example.com',
    ]);

    expect($user->refresh()->email_verified_at)->toBeNull();
});

test('keeps email verification when the email address is unchanged', function (): void {
    $user = User::factory()->create(['email_verified_at' => now()]);

    resolve(UpdateUserProfile::class)->handle($user, [
        'name' => 'New Name',
        'email' => $user->email,
    ]);

    expect($user->refresh()->email_verified_at)->not->toBeNull();
});
