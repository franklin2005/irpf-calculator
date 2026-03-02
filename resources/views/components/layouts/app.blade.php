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
    $sectionCanonical = trim($__env->yieldContent('canonical'));

    $fallbackTitle = match ($routeName) {
        'home' => 'Calculadora de IRPF en España por año y comunidad autónoma',
        'irpf.calculator' => 'Calculadora IRPF '.($routeYear ?? 2026).' por comunidades autónomas',
        default => 'Calculadora de IRPF en España',
    };

    $fallbackMetaDescription = match ($routeName) {
        'home' => 'Calcula de forma orientativa tu IRPF por año y comunidad autónoma en España (régimen común).',
        'irpf.calculator' => 'Simula de forma aproximada tu cuota de IRPF por año y comunidad autónoma del régimen común.',
        default => 'Herramienta informativa para estimar el IRPF en España. Resultado orientativo, no constituye asesoría fiscal.',
    };

    $resolvedTitle = $routeName === 'irpf.calculator'
        ? ($sectionTitle !== '' ? $sectionTitle : $fallbackTitle)
        : ($sectionTitle !== '' ? $sectionTitle : ($title ?? $fallbackTitle));

    $resolvedMetaDescription = $routeName === 'irpf.calculator'
        ? ($sectionMetaDescription !== '' ? $sectionMetaDescription : $fallbackMetaDescription)
        : ($sectionMetaDescription !== '' ? $sectionMetaDescription : ($metaDescription ?? $fallbackMetaDescription));

    $canonicalUrl = $sectionCanonical !== '' ? $sectionCanonical : ($canonical ?? request()->url());
    $openGraphUrl = request()->fullUrl();
    $openGraphLocale = app()->getLocale() === 'es'
        ? 'es_ES'
        : str_replace('-', '_', app()->getLocale());
    $ga4MeasurementId = trim((string) config('services.analytics.ga4_id'));
    $ga4MeasurementId = $ga4MeasurementId !== '' ? $ga4MeasurementId : null;
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
        @if ($ga4MeasurementId !== null)
            <script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga4MeasurementId }}"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag() { dataLayer.push(arguments); }
                gtag('js', new Date());
                gtag('config', '{{ $ga4MeasurementId }}');
            </script>
        @endif

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=Bebas+Neue&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="min-h-screen bg-[var(--irpf-bg)] text-[var(--irpf-ink)] antialiased selection:bg-cyan-300/20">
        <header class="border-b border-[var(--irpf-line)]/60 bg-black/20">
            <nav class="mx-auto flex w-full max-w-6xl items-center justify-between px-4 py-3 md:px-8">
                <a href="{{ route('home', [], false) }}" wire:navigate class="text-sm font-semibold uppercase tracking-[0.16em] text-[var(--irpf-teal)]">
                    IRPF España
                </a>
                <div class="flex items-center gap-4 text-sm text-[var(--irpf-muted)]">
                    <a href="{{ route('home', [], false) }}" wire:navigate class="transition hover:text-[var(--irpf-ink)]">Inicio</a>
                    <a href="{{ route('irpf.calculator', ['year' => 2026], false) }}" wire:navigate class="transition hover:text-[var(--irpf-ink)]">Calculadora 2026</a>
                    <a href="{{ route('irpf.region.show', ['year' => 2026, 'regionSlug' => 'asturias'], false) }}" wire:navigate class="transition hover:text-[var(--irpf-ink)]">Información CCAA</a>
                </div>
            </nav>
        </header>

        {{ $slot }}

        <footer class="border-t border-[var(--irpf-line)]/60 bg-black/20">
            <div class="mx-auto w-full max-w-6xl px-4 py-4 text-xs text-[var(--irpf-muted)] md:px-8">
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('home', [], false) }}" wire:navigate class="transition hover:text-[var(--irpf-ink)]">Inicio</a>
                    <a href="{{ route('irpf.calculator', ['year' => 2026], false) }}" wire:navigate class="transition hover:text-[var(--irpf-ink)]">Calculadora 2026</a>
                    <a href="{{ route('legal.notice', [], false) }}" wire:navigate class="transition hover:text-[var(--irpf-ink)]">Aviso legal</a>
                    <a href="{{ route('legal.privacy', [], false) }}" wire:navigate class="transition hover:text-[var(--irpf-ink)]">Política de privacidad</a>
                    <a href="{{ route('legal.cookies', [], false) }}" wire:navigate class="transition hover:text-[var(--irpf-ink)]">Política de cookies</a>
                </div>
                <p class="mt-3">Resultado orientativo para el régimen común del IRPF en España.</p>
                <p class="mt-2">
                    Este sitio puede utilizar cookies técnicas para su funcionamiento y, en su caso, herramientas de análisis.
                    Consulta la <a href="{{ route('legal.cookies', [], false) }}" wire:navigate class="underline underline-offset-2 transition hover:text-[var(--irpf-ink)]">Política de cookies</a>.
                </p>
            </div>
        </footer>

        @livewireScripts
        @fluxScripts
    </body>
</html>
