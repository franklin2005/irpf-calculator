@section('title', $seoTitle)
@section('meta_description', $seoDescription)
@section('meta:title', $seoTitle)
@section('meta:description', $seoDescription)
@section('canonical', route('irpf.region.show', ['year' => $year, 'regionSlug' => $regionSlug]))

<div class="irpf-app-bg min-h-screen">
    <div class="mx-auto flex w-full max-w-6xl flex-col gap-6 px-4 py-6 md:px-8 md:py-10">
        <nav aria-label="Breadcrumb" class="text-sm text-[var(--irpf-muted)]">
            <ol class="flex flex-wrap items-center gap-2">
                <li><a href="{{ route('home') }}" class="transition hover:text-[var(--irpf-ink)]">Inicio</a></li>
                <li aria-hidden="true">&gt;</li>
                <li><a href="{{ route('irpf.calculator', ['year' => $year]) }}" class="transition hover:text-[var(--irpf-ink)]">IRPF {{ $year }}</a></li>
                <li aria-hidden="true">&gt;</li>
                <li class="text-[var(--irpf-ink)]">{{ $regionName }}</li>
            </ol>
        </nav>

        <header class="irpf-panel rounded-3xl px-5 py-6 md:px-8">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[var(--irpf-teal)]">SEO CCAA</p>
            <h1 class="irpf-display mt-2 text-5xl leading-none text-[var(--irpf-ink)] md:text-7xl">IRPF {{ $year }} en {{ $regionName }}</h1>
            <p class="mt-3 max-w-3xl text-sm text-[var(--irpf-muted)] md:text-base">
                Bloque informativo base en construccion. Placeholder de contenido regional para SEO.
            </p>
        </header>

        <section class="irpf-panel rounded-3xl p-5 md:p-7">
            <h2 class="irpf-display text-4xl text-[var(--irpf-ink)] md:text-5xl">Resumen rapido</h2>
            <p class="mt-3 text-sm text-[var(--irpf-muted)]">Placeholder de secciones IRPF por comunidad autonoma.</p>

            <a
                href="{{ route('irpf.calculator', ['year' => $year, 'regionSlug' => $regionSlug]) }}"
                class="mt-5 inline-flex items-center rounded-xl border border-[var(--irpf-line)] bg-[var(--irpf-panel)] px-4 py-2 text-sm font-semibold text-[var(--irpf-ink)] transition hover:border-[var(--irpf-teal)] hover:text-[var(--irpf-teal)]"
            >
                Ir a la calculadora IRPF
            </a>
        </section>

        <section class="irpf-panel rounded-3xl p-5 md:p-7">
            <h2 class="irpf-display text-4xl text-[var(--irpf-ink)] md:text-5xl">Tramos IRPF {{ $year }} en {{ $regionName }}</h2>
            <p class="mt-3 text-sm text-[var(--irpf-muted)]">
                Visualizacion de tramos cargados desde tablas fiscales para {{ $regionName }}.
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
                    <h3 class="text-sm font-semibold uppercase tracking-[0.14em] text-[var(--irpf-muted)]">Tramos autonomicos</h3>
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
            <h2 class="irpf-display text-4xl text-[var(--irpf-ink)] md:text-5xl">Ejemplos de calculo</h2>
            <p class="mt-3 text-sm text-[var(--irpf-muted)]">
                Simulaciones orientativas para distintos perfiles con el motor actual.
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
                    <p class="text-sm text-[var(--irpf-muted)]">No hay ejemplos disponibles para esta combinacion.</p>
                @endforelse
            </div>
        </section>

        <section class="ad-slot irpf-soft-card min-h-32 rounded-3xl p-5" aria-label="Espacio para anuncios">
            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[var(--irpf-muted)]">Ad Slot</p>
            <p class="mt-2 text-sm text-[var(--irpf-muted)]">Placeholder de bloque publicitario.</p>
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
