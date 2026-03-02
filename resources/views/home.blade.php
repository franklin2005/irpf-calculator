@php
    $allRegions = [
        'andalucia' => 'Andalucía',
        'aragon' => 'Aragón',
        'asturias' => 'Asturias',
        'baleares' => 'Baleares',
        'canarias' => 'Canarias',
        'cantabria' => 'Cantabria',
        'castilla_la_mancha' => 'Castilla-La Mancha',
        'castilla_y_leon' => 'Castilla y León',
        'cataluna' => 'Cataluña',
        'comunidad_valenciana' => 'Comunidad Valenciana',
        'extremadura' => 'Extremadura',
        'galicia' => 'Galicia',
        'la_rioja' => 'La Rioja',
        'madrid' => 'Comunidad de Madrid',
        'murcia' => 'Murcia',
        'navarra' => 'Navarra',
        'pais_vasco' => 'País Vasco',
    ];

    $featuredRegionSlugs = ['asturias', 'madrid', 'cataluna', 'comunidad_valenciana'];
@endphp

<x-layouts.app
    title="Calculadora de IRPF en España por año y comunidad autónoma"
    meta-description="Calcula de forma orientativa tu IRPF para 2025 y 2026 según ingresos, situación familiar y comunidad autónoma."
    :canonical="route('home')"
>
    <main class="irpf-app-bg min-h-screen">
        <div class="mx-auto w-full max-w-6xl px-4 py-10 md:px-8 md:py-14">
            <section class="irpf-panel rounded-3xl px-6 py-10 text-center md:px-10">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[var(--irpf-teal)]">IRPF España</p>
                <h1 class="irpf-display mt-3 text-5xl leading-none text-[var(--irpf-ink)] md:text-7xl">
                    Calculadora de IRPF 2025 y 2026 por comunidad autónoma
                </h1>
                <p class="mx-auto mt-4 max-w-3xl text-sm font-medium text-[var(--irpf-muted)] md:text-base">
                    Obtén una estimación orientativa de tu cuota de IRPF según tus ingresos, el año fiscal y la comunidad autónoma
                    del régimen común en España.
                </p>
                <div class="mt-7 flex flex-wrap items-center justify-center gap-3">
                    <flux:button :href="route('irpf.calculator', ['year' => 2026], false)" variant="primary" aria-label="Ir a la calculadora de IRPF 2026" wire:navigate>
                        Calcular IRPF
                    </flux:button>

                    <div
                        x-data="{ open: false }"
                        class="irpf-region-dropdown relative inline-flex"
                        @keydown.escape.window="open = false"
                    >
                        <button
                            type="button"
                            class="irpf-region-trigger inline-flex h-10 items-center gap-1.5 rounded-lg px-3 text-left text-sm"
                            @click="open = ! open"
                            :aria-expanded="open ? 'true' : 'false'"
                            aria-haspopup="listbox"
                        >
                            <span>Ver información por comunidad</span>
                            <flux:icon.chevron-down class="size-4 transition" x-bind:class="open ? 'rotate-180' : ''" />
                        </button>

                        <div
                            x-cloak
                            x-show="open"
                            x-transition.origin.top
                            @click.outside="open = false"
                            class="irpf-region-menu absolute top-[calc(100%+0.4rem)] left-0 z-40 max-h-80 min-w-72 overflow-auto rounded-lg p-[.3125rem]"
                            role="listbox"
                        >
                            <p class="px-2 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-[var(--irpf-muted)]">IRPF 2026</p>
                            @foreach ($allRegions as $slug => $label)
                                <a
                                    href="{{ route('irpf.region.show', ['year' => 2026, 'regionSlug' => $slug], false) }}"
                                    wire:navigate
                                    class="irpf-region-option mb-1 flex w-full items-center rounded-md px-2 py-1.5 text-left text-sm font-medium"
                                >
                                    {{ $label }}
                                </a>
                            @endforeach

                            <p class="mt-1 px-2 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-[var(--irpf-muted)]">IRPF 2025</p>
                            @foreach ($allRegions as $slug => $label)
                                <a
                                    href="{{ route('irpf.region.show', ['year' => 2025, 'regionSlug' => $slug], false) }}"
                                    wire:navigate
                                    class="irpf-region-option mb-1 flex w-full items-center rounded-md px-2 py-1.5 text-left text-sm font-medium"
                                >
                                    {{ $label }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <section class="ad-slot irpf-soft-card mt-6 min-h-28 rounded-3xl p-5" aria-label="Espacio para anuncios">
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[var(--irpf-muted)]">Espacio para anuncios</p>
                <p class="mt-2 text-sm text-[var(--irpf-muted)]">
                    Bloque reservado para futuras integraciones publicitarias, manteniendo la estabilidad visual de la página.
                </p>
            </section>

            <section class="mt-6 grid gap-6 lg:grid-cols-2">
                <article class="irpf-soft-card rounded-3xl p-5">
                    <h2 class="text-lg font-semibold text-[var(--irpf-ink)]">Qué incluye esta calculadora</h2>
                    <ul class="mt-3 space-y-2 text-sm text-[var(--irpf-ink)]">
                        <li>Estimación de IRPF con ingresos brutos anuales.</li>
                        <li>Selección de año fiscal: 2025 o 2026.</li>
                        <li>Selección de comunidad autónoma del régimen común.</li>
                        <li>Ajuste básico por situación familiar (número de hijos).</li>
                        <li>Desglose de cuota estatal, autonómica y tipo efectivo.</li>
                    </ul>
                </article>

                <article class="irpf-soft-card rounded-3xl p-5">
                    <h2 class="text-lg font-semibold text-[var(--irpf-ink)]">Qué no incluye esta herramienta</h2>
                    <ul class="mt-3 space-y-2 text-sm text-[var(--irpf-ink)]">
                        <li>No sustituye asesoramiento fiscal profesional.</li>
                        <li>No contempla todos los supuestos personales complejos.</li>
                        <li>No incorpora todas las deducciones y ajustes avanzados.</li>
                        <li>No equivale a una liquidación oficial de la Agencia Tributaria.</li>
                    </ul>
                </article>
            </section>

            <section class="irpf-panel mt-6 rounded-3xl p-5 md:p-7">
                <h2 class="irpf-display text-4xl text-[var(--irpf-ink)] md:text-5xl">Información del IRPF por comunidad autónoma</h2>
                <p class="mt-3 max-w-3xl text-sm text-[var(--irpf-muted)]">
                    Consulta tramos estatales y autonómicos, junto con ejemplos orientativos de cálculo para cada comunidad y año.
                </p>

                <div class="mt-5 grid gap-6 lg:grid-cols-2">
                    <article class="irpf-soft-card rounded-2xl p-4">
                        <h3 class="text-sm font-semibold uppercase tracking-[0.14em] text-[var(--irpf-muted)]">Enlaces destacados 2026</h3>
                        <ul class="mt-3 space-y-2 text-sm">
                            @foreach ($featuredRegionSlugs as $slug)
                                <li>
                                    <a
                                        href="{{ route('irpf.region.show', ['year' => 2026, 'regionSlug' => $slug], false) }}"
                                        class="text-[var(--irpf-teal)] transition hover:text-cyan-300"
                                        wire:navigate
                                    >
                                        IRPF 2026 en {{ $allRegions[$slug] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </article>

                    <article class="irpf-soft-card rounded-2xl p-4">
                        <h3 class="text-sm font-semibold uppercase tracking-[0.14em] text-[var(--irpf-muted)]">Enlaces destacados 2025</h3>
                        <ul class="mt-3 space-y-2 text-sm">
                            @foreach ($featuredRegionSlugs as $slug)
                                <li>
                                    <a
                                        href="{{ route('irpf.region.show', ['year' => 2025, 'regionSlug' => $slug], false) }}"
                                        class="text-[var(--irpf-teal)] transition hover:text-cyan-300"
                                        wire:navigate
                                    >
                                        IRPF 2025 en {{ $allRegions[$slug] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </article>
                </div>
            </section>
        </div>
    </main>
</x-layouts.app>
