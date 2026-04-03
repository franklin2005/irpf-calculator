# IRPF Calculator

Versión en español: [README.md](README.md)

## Goal
Application to calculate Personal Income Tax (IRPF) in Spain, using server-side rendering (SSR), a reactive interface with Livewire, and UI components with Flux.

## Tech stack
- Laravel 12
- Livewire 4
- Flux UI Free v2
- PHP 8.2
- Vite + Tailwind CSS
- PHPUnit
- Laravel Pint
- Laravel Boost / MCP

## Requirements
- PHP 8.2+
- Composer
- Node.js + npm
- Local environment with XAMPP (Apache/PHP/MySQL depending on your setup)

## Local run
```bash
composer install
npm install
npm run dev
```

Options to serve the app:
```bash
php artisan serve
```
or serve the project with Apache in XAMPP.

## Quality
```bash
composer test
```

Optional commands (if defined in `composer.json`):
```bash
composer lint
composer analyse
```

## Screenshots
In the `screenshots/` folder (project root) you can find current application screenshots:

- Home: `screenshots/home.png`, `screenshots/home2.png`
- Calculator: `screenshots/calculadora.png`, `screenshots/calculadora2.png`
- Region information page: `screenshots/info.png`, `screenshots/info2.png`