<?php

declare(strict_types=1);

use App\Providers\AppServiceProvider;
use Illuminate\Validation\Rules\Password;

test('production password defaults use a password rule', function (): void {
    try {
        $this->app->detectEnvironment(fn (): string => 'production');

        $provider = new AppServiceProvider($this->app);
        $method = new ReflectionMethod($provider, 'configureDefaults');
        $method->invoke($provider);

        expect(Password::defaults()->toPasswordRulesString())->toContain(
            'minlength: 12',
            'required: lower',
            'required: upper',
            'required: digit',
            'required: special',
        );
    } finally {
        $this->app->detectEnvironment(fn (): string => 'testing');

        $provider = new AppServiceProvider($this->app);
        $method = new ReflectionMethod($provider, 'configureDefaults');
        $method->invoke($provider);
    }
});
