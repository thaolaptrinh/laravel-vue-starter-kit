<?php

declare(strict_types=1);

use App\Actions\UpdateUserPassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('updates the user password', function (): void {
    $user = User::factory()->create();

    resolve(UpdateUserPassword::class)->handle($user, 'new-password');

    expect(Hash::check('new-password', $user->refresh()->password))->toBeTrue();
});
