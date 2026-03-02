@section('title', $seoTitle)
@section('meta_description', $seoDescription)
@section('meta:title', $seoTitle)
@section('meta:description', $seoDescription)
@section('canonical', route('irpf.region.show', ['year' => $year, 'regionSlug' => $regionSlug]))

<div class="irpf-app-bg min-h-screen">
    <div class="mx-auto flex w-full max-w-6xl flex-col gap-6 px-4 py-6 md:px-8 md:py-10">
        <nav aria-label="Breadcrumb" class="text-sm text-[var(--irpf-muted)]">
            <ol class="flex flex-wrap items-center gap-2">
                <li>
                    <a
                        href="{{ route('home', [], false) }}"
                        class="irpf-region-trigger inline-flex h-8 items-center rounded-lg px-3 text-left text-sm font-medium text-[var(--irpf-ink)] transition"
                        wire:navigate
                    >
                        Inicio
                    </a>
                </li>
                <li aria-hidden="true">&gt;</li>
                <li
                    x-data="{ open: false }"
                    class="irpf-region-dropdown relative"
                    @keydown.escape.window="open = false"
                >
                    <button
                        type="button"
                        class="irpf-region-trigger inline-flex h-8 items-center gap-2 rounded-lg px-3 text-left text-sm font-medium text-[var(--irpf-ink)]"
                        @click="open = ! open"
                        :aria-expanded="open ? 'true' : 'false'"
                        aria-haspopup="listbox"
                    >
                        <span>IRPF {{ $year }}</span>
                        <flux:icon.chevron-down class="size-4 transition" x-bind:class="open ? 'rotate-180' : ''" />
                    </button>

                    <div
                        x-cloak
                        x-show="open"
                        x-transition.origin.top
                        @click.outside="open = false"
                        class="irpf-region-menu absolute top-[calc(100%+0.4rem)] left-0 z-40 min-w-44 overflow-auto rounded-lg p-[.3125rem]"
                        role="listbox"
                    >
                        @foreach ([2025, 2026] as $yearOption)
                            <a
                                href="{{ route('irpf.region.show', ['year' => $yearOption, 'regionSlug' => $regionSlug], false) }}"
                                wire:navigate
                                class="{{ $year === $yearOption ? 'irpf-region-option-active' : 'irpf-region-option' }} mb-1 flex w-full items-center rounded-md px-2 py-1.5 text-left text-sm font-medium"
                            >
                                IRPF {{ $yearOption }}
                            </a>
                        @endforeach
                    </div>
                </li>
                <li aria-hidden="true">&gt;</li>
                <li
                    x-data="{ open: false }"
                    class="irpf-region-dropdown relative"
                    @keydown.escape.window="open = false"
                >
                    <button
                        type="button"
                        class="irpf-region-trigger inline-flex h-8 items-center gap-2 rounded-lg px-3 text-left text-sm font-medium text-[var(--irpf-ink)]"
                        @click="open = ! open"
                        :aria-expanded="open ? 'true' : 'false'"
                        aria-haspopup="listbox"
                    >
                        <span>{{ $regionName }}</span>
                        <flux:icon.chevron-down class="size-4 transition" x-bind:class="open ? 'rotate-180' : ''" />
                    </button>

                    <div
                        x-cloak
                        x-show="open"
                        x-transition.origin.top
                        @click.outside="open = false"
                        class="irpf-region-menu absolute top-[calc(100%+0.4rem)] left-0 z-40 max-h-72 min-w-56 overflow-auto rounded-lg p-[.3125rem]"
                        role="listbox"
                    >
                        @foreach ($regionOptions as $slug => $label)
                            <a
                                href="{{ route('irpf.region.show', ['year' => $year, 'regionSlug' => $slug], false) }}"
                                wire:navigate
                                class="{{ $regionSlug === $slug ? 'irpf-region-option-active' : 'irpf-region-option' }} mb-1 flex w-full items-center rounded-md px-2 py-1.5 text-left text-sm font-medium"
                            >
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </li>
            </ol>
        </nav>

        <header class="irpf-panel rounded-3xl px-5 py-6 md:px-8">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[var(--irpf-teal)]">Información fiscal por CCAA</p>
            <h1 class="irpf-display mt-2 text-5xl leading-none text-[var(--irpf-ink)] md:text-7xl">IRPF {{ $year }} en {{ $regionName }}</h1>
            <p class="mt-3 max-w-3xl text-sm text-[var(--irpf-muted)] md:text-base">
                Consulta un resumen orientativo de tramos estatales y autonómicos para {{ $regionName }}.
                Esta información puede variar según actualizaciones normativas posteriores.
            </p>
        </header>

        <section class="irpf-panel rounded-3xl p-5 md:p-7">
            <h2 class="irpf-display text-4xl text-[var(--irpf-ink)] md:text-5xl">Resumen y acceso a la calculadora</h2>
            <p class="mt-3 text-sm text-[var(--irpf-muted)]">
                También puedes ir directamente a la calculadora con el año y la comunidad autónoma ya seleccionados.
            </p>

            <a
                href="{{ route('irpf.calculator', ['year' => $year, 'regionSlug' => $regionSlug], false) }}"
                wire:navigate
                class="mt-5 inline-flex items-center rounded-xl border border-[var(--irpf-line)] bg-[var(--irpf-panel)] px-4 py-2 text-sm font-semibold text-[var(--irpf-ink)] transition hover:border-[var(--irpf-teal)] hover:text-[var(--irpf-teal)]"
            >
                Ir a la calculadora IRPF de {{ $regionName }} ({{ $year }})
            </a>
        </section>

        <section class="irpf-panel rounded-3xl p-5 md:p-7">
            <h2 class="irpf-display text-4xl text-[var(--irpf-ink)] md:text-5xl">Tramos IRPF {{ $year }} en {{ $regionName }}</h2>
            <p class="mt-3 text-sm text-[var(--irpf-muted)]">
                Visualización de tramos cargados para esta comunidad autónoma y año fiscal.
            </p>

            <div class="mt-5 grid gap-6 lg:grid-cols-2">
                <article class="irpf-soft-card rounded-2xl p-4">
                    <h3 class="text-sm font-semibold uppercase tracking-[0.14em] text-[var(--irpf-muted)]">Tramos estatales</h3>
                    <div class="mt-3 overflow-x-auto">
                        <table class="min-w-full text-sm text-[var(--irpf-ink)]">
                            <thead class="text-left text-xs uppercase tracking-[0.12em] text-[var(--irpf-muted)]">
                                <tr>
                                    <th class="px-2 py-2">Desde</th>
                                    <th class="px-2 py-2">Hasta</th>
                                    <th class="px-2 py-2">Tipo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($stateBrackets as $index => $bracket)
                                    <tr wire:key="state-bracket-{{ $index }}" class="border-t border-[var(--irpf-line)]/50">
                                        <td class="px-2 py-2">{{ number_format($bracket['from'], 0, ',', '.') }} EUR</td>
                                        <td class="px-2 py-2">{{ $bracket['to'] === null ? 'En adelante' : number_format($bracket['to'], 0, ',', '.').' EUR' }}</td>
                                        <td class="px-2 py-2">{{ number_format($bracket['rate'], 2, ',', '.') }}%</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-2 py-2 text-[var(--irpf-muted)]">Sin tramos disponibles.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </article>

                <article class="irpf-soft-card rounded-2xl p-4">
                    <h3 class="text-sm font-semibold uppercase tracking-[0.14em] text-[var(--irpf-muted)]">Tramos autonómicos</h3>
                    <div class="mt-3 overflow-x-auto">
                        <table class="min-w-full text-sm text-[var(--irpf-ink)]">
                            <thead class="text-left text-xs uppercase tracking-[0.12em] text-[var(--irpf-muted)]">
                                <tr>
                                    <th class="px-2 py-2">Desde</th>
                                    <th class="px-2 py-2">Hasta</th>
                                    <th class="px-2 py-2">Tipo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($regionalBrackets as $index => $bracket)
                                    <tr wire:key="regional-bracket-{{ $index }}" class="border-t border-[var(--irpf-line)]/50">
                                        <td class="px-2 py-2">{{ number_format($bracket['from'], 0, ',', '.') }} EUR</td>
                                        <td class="px-2 py-2">{{ $bracket['to'] === null ? 'En adelante' : number_format($bracket['to'], 0, ',', '.').' EUR' }}</td>
                                        <td class="px-2 py-2">{{ number_format($bracket['rate'], 2, ',', '.') }}%</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-2 py-2 text-[var(--irpf-muted)]">Sin tramos disponibles.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </article>
            </div>
        </section>

        <section class="irpf-panel rounded-3xl p-5 md:p-7">
            <h2 class="irpf-display text-4xl text-[var(--irpf-ink)] md:text-5xl">Ejemplos de cálculo</h2>
            <p class="mt-3 text-sm text-[var(--irpf-muted)]">
                Simulaciones orientativas para distintos perfiles de ingresos y situación familiar.
            </p>

            <div class="mt-5 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($exampleResults as $index => $exampleResult)
                    <article wire:key="example-result-{{ $index }}" class="irpf-soft-card rounded-2xl p-4">
                        <h3 class="text-sm font-semibold text-[var(--irpf-ink)]">{{ $exampleResult['label'] }}</h3>
                        <dl class="mt-3 space-y-2 text-sm text-[var(--irpf-muted)]">
                            <div class="flex items-center justify-between gap-2">
                                <dt>Bruto</dt>
                                <dd class="font-medium text-[var(--irpf-ink)]">{{ $exampleResult['gross_income'] }}</dd>
                            </div>
                            <div class="flex items-center justify-between gap-2">
                                <dt>Cuota total aprox.</dt>
                                <dd class="font-medium text-[var(--irpf-ink)]">{{ $exampleResult['total_tax'] }}</dd>
                            </div>
                            <div class="flex items-center justify-between gap-2">
                                <dt>Tipo efectivo aprox.</dt>
                                <dd class="font-medium text-[var(--irpf-teal)]">{{ $exampleResult['effective_rate'] }}</dd>
                            </div>
                        </dl>
                    </article>
                @empty
                    <p class="text-sm text-[var(--irpf-muted)]">No hay ejemplos disponibles para esta combinación.</p>
                @endforelse
            </div>
        </section>

        <section class="ad-slot irpf-soft-card min-h-32 rounded-3xl p-5" aria-label="Espacio para anuncios">
            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[var(--irpf-muted)]">Espacio publicitario</p>
            <p class="mt-2 text-sm text-[var(--irpf-muted)]">Bloque reservado para publicidad y colaboraciones futuras.</p>
        </section>
    </div>
</div>

<script>
    (() => {
        if (window.__regionAnalyticsBound) {
            return;
        }

        window.__regionAnalyticsBound = true;

        window.addEventListener('region-page-viewed', (event) => {
            if (typeof window.gtag !== 'function') {
                return;
            }

            const detail = event.detail ?? {};

            window.gtag('event', 'view_region_page', {
                year: detail.year ?? null,
                region_slug: detail.regionSlug ?? null,
                region_name: detail.regionName ?? null,
            });
        });
    })();
</script>
