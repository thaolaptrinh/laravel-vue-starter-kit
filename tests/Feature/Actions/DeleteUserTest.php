<?php

declare(strict_types=1);

use App\Actions\DeleteUser;
use App\Models\User;

test('deletes the given user account', function (): void {
    $user = User::factory()->create();

    resolve(DeleteUser::class)->handle($user);

    expect(User::query()->find($user->id))->toBeNull();
});
