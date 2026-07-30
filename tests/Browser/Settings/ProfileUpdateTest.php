<?php

declare(strict_types=1);

use App\Models\User;

test('profile page is displayed', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->visit(route('profile.edit', absolute: false))
        ->assertNoJavaScriptErrors()
        ->assertValue('name', $user->name)
        ->assertValue('email', $user->email);
});

test('profile information can be updated', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->visit(route('profile.edit', absolute: false))
        ->clear('name')
        ->type('name', 'Updated Name')
        ->press('@update-profile-button')
        ->wait(1)
        ->assertPathIs('/settings/profile')
        ->assertSee('Updated Name')
        ->assertNoJavaScriptErrors();
});

test('user can delete their account', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->visit(route('profile.edit', absolute: false))
        ->press('@delete-user-button')
        ->wait(1)
        ->type('password', 'password')
        ->press('@confirm-delete-user-button')
        ->wait(2)
        ->assertPathIs('/')
        ->assertNoJavaScriptErrors();

    expect(User::query()->find($user->id))->toBeNull();
});
