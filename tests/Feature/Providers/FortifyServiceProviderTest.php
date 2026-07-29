<?php

declare(strict_types=1);

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

function fortifyRateLimitRequestWithSession(array $parameters = []): Request
{
    $request = Request::create('/', 'POST', $parameters);
    $request->setLaravelSession(app('session.store'));

    return $request;
}

test('two factor limiter uses the login session id', function () {
    $request = fortifyRateLimitRequestWithSession();
    $request->session()->put('login.id', 123);

    $limit = RateLimiter::limiter('two-factor')($request);

    expect($limit)->toBeInstanceOf(Limit::class)
        ->and($limit->maxAttempts)->toBe(5)
        ->and($limit->decaySeconds)->toBe(60)
        ->and($limit->key)->toBe(123);
});

test('passkey limiter uses the credential id when present', function () {
    $request = fortifyRateLimitRequestWithSession(['credential' => ['id' => 'credential-id']]);

    $limit = RateLimiter::limiter('passkeys')($request);

    expect($limit)->toBeInstanceOf(Limit::class)
        ->and($limit->maxAttempts)->toBe(10)
        ->and($limit->decaySeconds)->toBe(60)
        ->and($limit->key)->toBe('credential-id|127.0.0.1');
});

test('passkey limiter falls back to the session id', function () {
    $request = fortifyRateLimitRequestWithSession();

    $limit = RateLimiter::limiter('passkeys')($request);

    expect($limit)->toBeInstanceOf(Limit::class)
        ->and($limit->maxAttempts)->toBe(10)
        ->and($limit->decaySeconds)->toBe(60)
        ->and($limit->key)->toBe($request->session()->getId().'|127.0.0.1');
});
