<?php

declare(strict_types=1);

use App\Models\User;

test('welcome page shows login and register links for guests', function (): void {
    $this->visit('/')
        ->assertSeeLink('Log in')
        ->assertSeeLink('Register')
        ->assertDontSeeLink('Dashboard');
});

test('welcome page shows dashboard link for authenticated users', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->visit('/')
        ->assertSeeLink('Dashboard');
});

test('guests are redirected away from the dashboard', function (): void {
    $this->visit('/dashboard')
        ->wait(1)
        ->assertPathIs('/login');
});

test('guests can navigate from the welcome page to the login screen', function (): void {
    $this->visit('/')
        ->click('Log in')
        ->wait(1)
        ->assertPathIs('/login');
});

test('authenticated users can navigate from the welcome page to the dashboard', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->visit('/')
        ->click('Dashboard')
        ->wait(1)
        ->assertPathIs('/dashboard');
});

test('authenticated users can navigate to settings from the user menu', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->visit('/dashboard')
        ->wait(1)
        ->click('@sidebar-menu-button')
        ->wait(1)
        ->click('Settings')
        ->wait(1)
        ->assertPathIs('/settings/profile');
});
