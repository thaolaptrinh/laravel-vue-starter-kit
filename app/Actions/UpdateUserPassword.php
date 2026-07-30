<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;

final readonly class UpdateUserPassword
{
    /**
     * Update the given user's password.
     */
    public function handle(User $user, string $password): void
    {
        $user->update([
            'password' => $password,
        ]);
    }
}
