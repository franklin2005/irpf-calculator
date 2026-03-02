<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Calculadora IRPF') }}</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="min-h-screen bg-zinc-950 text-zinc-100 antialiased">
        <main class="mx-auto flex min-h-screen w-full max-w-4xl flex-col items-center justify-center px-6 text-center">
            <h1 class="text-4xl font-semibold md:text-5xl">Calculadora de IRPF para España</h1>
            <p class="mt-4 max-w-2xl text-sm text-zinc-300 md:text-base">
                Herramienta orientativa para estimar tu IRPF por año y comunidad autónoma.
            </p>
            <a
                href="{{ route('home') }}"
                class="mt-8 inline-flex items-center rounded-xl bg-cyan-500 px-5 py-3 text-sm font-semibold text-zinc-950 transition hover:bg-cyan-400"
            >
                Ir al inicio
            </a>
        </main>
    </body>
</html>
