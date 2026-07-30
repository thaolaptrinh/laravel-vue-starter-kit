<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\DB;

final readonly class DeleteUser
{
    /**
     * Delete the given user account within a transaction so any future
     * related side effects stay atomic.
     */
    public function handle(User $user): void
    {
        DB::transaction(fn () => $user->delete());
    }
}
