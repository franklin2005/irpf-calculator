@props([
    'title' => null,
    'metaDescription' => null,
    'canonical' => null,
])

@php
    $routeName = request()->route()?->getName();
    $routeYear = request()->route('year');

    $sectionTitle = trim($__env->yieldContent('title'));
    $sectionMetaDescription = trim($__env->yieldContent('meta_description'));

    $fallbackTitle = match ($routeName) {
        'home' => 'Calculadora IRPF 2026 para Espana - Explicacion y acceso',
        'irpf.calculator' => 'Calculadora IRPF '.($routeYear ?? 2026).' Asturias - Simulador de IRPF estimado',
        default => 'Calculadora IRPF Espana',
    };

    $fallbackMetaDescription = match ($routeName) {
        'home' => 'Calculadora IRPF 2026 para Espana con explicacion del MVP y acceso al simulador de Asturias.',
        'irpf.calculator' => 'Calculadora IRPF 2026 para Asturias con simulacion estimada de cuota total y tipo efectivo.',
        default => 'Calculadora IRPF para Espana con calculo estimado del impuesto sobre la renta. Proyecto educativo, no asesoria fiscal.',
    };

    $resolvedTitle = $routeName === 'irpf.calculator'
        ? ($sectionTitle !== '' ? $sectionTitle : $fallbackTitle)
        : ($sectionTitle !== '' ? $sectionTitle : ($title ?? $fallbackTitle));

    $resolvedMetaDescription = $routeName === 'irpf.calculator'
        ? ($sectionMetaDescription !== '' ? $sectionMetaDescription : $fallbackMetaDescription)
        : ($sectionMetaDescription !== '' ? $sectionMetaDescription : ($metaDescription ?? $fallbackMetaDescription));

    $canonicalUrl = $canonical ?? request()->url();
    $openGraphUrl = request()->fullUrl();
    $openGraphLocale = app()->getLocale() === 'es'
        ? 'es_ES'
        : str_replace('-', '_', app()->getLocale());
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $resolvedTitle }}</title>
        <meta name="description" content="{{ $resolvedMetaDescription }}">
        <link rel="canonical" href="{{ $canonicalUrl }}">

        <meta property="og:title" content="{{ $resolvedTitle }}">
        <meta property="og:description" content="{{ $resolvedMetaDescription }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ $openGraphUrl }}">
        <meta property="og:locale" content="{{ $openGraphLocale }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=Bebas+Neue&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="min-h-screen bg-[var(--irpf-bg)] text-[var(--irpf-ink)] antialiased selection:bg-cyan-300/20">
        <header class="border-b border-[var(--irpf-line)]/60 bg-black/20">
            <nav class="mx-auto flex w-full max-w-6xl items-center justify-between px-4 py-3 md:px-8">
                <a href="{{ route('home') }}" class="text-sm font-semibold uppercase tracking-[0.16em] text-[var(--irpf-teal)]">
                    IRPF 2026
                </a>
                <div class="flex items-center gap-4 text-sm text-[var(--irpf-muted)]">
                    <a href="{{ route('home') }}" class="transition hover:text-[var(--irpf-ink)]">Inicio</a>
                    <a href="{{ route('irpf.calculator', ['year' => 2026]) }}" class="transition hover:text-[var(--irpf-ink)]">Calculadora</a>
                </div>
            </nav>
        </header>

        {{ $slot }}

        <footer class="border-t border-[var(--irpf-line)]/60 bg-black/20">
            <div class="mx-auto flex w-full max-w-6xl flex-col gap-3 px-4 py-4 text-xs text-[var(--irpf-muted)] md:flex-row md:items-center md:justify-between md:px-8">
                <p>Proyecto educativo de simulacion IRPF. Resultado orientativo.</p>
                <div class="flex items-center gap-3">
                    <a href="{{ url('/aviso-legal') }}" class="transition hover:text-[var(--irpf-ink)]">Aviso legal</a>
                    <a href="{{ url('/privacidad') }}" class="transition hover:text-[var(--irpf-ink)]">Privacidad</a>
                </div>
            </div>
        </footer>

        @livewireScripts
        @fluxScripts
    </body>
</html>
