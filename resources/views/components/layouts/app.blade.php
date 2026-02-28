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
            <div class="mx-auto w-full max-w-6xl px-4 py-4 text-xs text-[var(--irpf-muted)] md:px-8">
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('home') }}" class="transition hover:text-[var(--irpf-ink)]">Inicio</a>
                    <a href="{{ route('irpf.calculator', ['year' => 2026]) }}" class="transition hover:text-[var(--irpf-ink)]">Calculadora 2026</a>
                    <a href="{{ route('legal.notice') }}" class="transition hover:text-[var(--irpf-ink)]">Aviso legal</a>
                    <a href="{{ route('legal.privacy') }}" class="transition hover:text-[var(--irpf-ink)]">Politica de privacidad</a>
                    <a href="{{ route('legal.cookies') }}" class="transition hover:text-[var(--irpf-ink)]">Politica de cookies</a>
                </div>
                <p class="mt-3">Proyecto educativo de simulacion IRPF. Resultado orientativo.</p>
                <p class="mt-2">
                    Este sitio puede utilizar cookies tecnicas y, en el futuro, herramientas de analisis o publicidad.
                    Consulta la <a href="{{ route('legal.cookies') }}" class="underline underline-offset-2 transition hover:text-[var(--irpf-ink)]">Politica de cookies</a>.
                </p>
            </div>
        </footer>

        @livewireScripts
        @fluxScripts
    </body>
</html>
