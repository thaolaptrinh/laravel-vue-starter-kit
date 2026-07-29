# Laravel + Vue Starter Kit

## Introduction

This starter kit provides a robust, modern starting point for building Laravel applications with a Vue frontend using [Inertia](https://inertiajs.com).

Inertia allows you to build modern, single-page Vue applications using classic server-side routing and controllers. This lets you enjoy the frontend power of Vue combined with the backend productivity of Laravel and fast Vite compilation.

This project uses Laravel, Vue 3 with the Composition API, TypeScript, Tailwind CSS, Inertia, Wayfinder, and a strict quality toolchain for formatting, static analysis, refactoring, and test coverage.

## Features

- Laravel 13 and PHP 8.5
- Vue 3, TypeScript, and Inertia 3
- Tailwind CSS 4
- Wayfinder for typed route and controller helpers
- Fortify authentication with passkey and two-factor support
- Laravel Sail with PostgreSQL and Redis for local development
- Laravel Essentials for stricter application defaults
- Pest, Larastan, Pint, Rector, and type coverage checks
- Roave Security Advisories for Composer dependency safety

## Getting Started

Start the Sail containers:

```bash
vendor/bin/sail up -d
```

Install dependencies, configure the application, run migrations, and build frontend assets:

```bash
vendor/bin/sail composer run setup
```

Start the development environment:

```bash
vendor/bin/sail composer run dev
```

Run the full quality and test suite:

```bash
vendor/bin/sail composer test
```

Run formatters and automated refactors:

```bash
vendor/bin/sail composer lint
```

## Documentation

Useful framework and package documentation:

- [Laravel](https://laravel.com/docs)
- [Inertia](https://inertiajs.com)
- [Vue](https://vuejs.org)
- [Tailwind CSS](https://tailwindcss.com)
- [Wayfinder](https://github.com/laravel/wayfinder)
- [Laravel Essentials](https://github.com/nunomaduro/essentials)
- [Pest](https://pestphp.com)

## Contributing

Thank you for considering contributing to this starter kit. Please keep changes focused, tested, and aligned with the existing Laravel, Vue, and TypeScript conventions.

Before submitting changes, run:

```bash
vendor/bin/sail composer test
```

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## License

The Laravel + Vue starter kit is open-source software licensed under the MIT license.
