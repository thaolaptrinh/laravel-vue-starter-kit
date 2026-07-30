<?php

declare(strict_types=1);

use App\Actions\DeleteUser;
use App\Models\User;

test('deletes the given user account', function (): void {
    $user = User::factory()->create();

    app(DeleteUser::class)->handle($user);

    expect(User::find($user->id))->toBeNull();
});
