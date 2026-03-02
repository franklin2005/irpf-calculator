<div wire:replace.self class="irpf-app-bg min-h-screen">
    @php
        $hasResult = $resultData !== null;
        $isUnsupportedForalError = $domainError !== null
            && (\Illuminate\Support\Str::of($domainError)->lower()->contains('régimen foral')
                || \Illuminate\Support\Str::of($domainError)->lower()->contains('regimen foral'));
        $grossIncomeEur = $resultData['gross_income_eur'] ?? 0;
        $netTaxableBaseEur = $resultData['net_taxable_base_eur'] ?? 0;
        $totalTaxEur = $resultData['total_tax_eur'] ?? 0;
        $effectiveRatePercent = $resultData['effective_rate_percent'] ?? 0;
        $personalMinimumEur = $resultData['personal_minimum_eur'] ?? 0;
        $familyMinimumEur = $resultData['family_minimum_eur'] ?? 0;
        $stateTaxEur = $resultData['state_tax_eur'] ?? 0;
        $regionalTaxEur = $resultData['regional_tax_eur'] ?? 0;
        $grossTaxEur = $resultData['gross_tax_eur'] ?? 0;
        $ceutaMelillaDeductionEur = $resultData['ceuta_melilla_deduction_eur'] ?? 0;
        $stateBracketsCount = $resultData['state_brackets_applied_count'] ?? 0;
        $regionalBracketsCount = $resultData['regional_brackets_applied_count'] ?? 0;
        $foralErrorParagraphs = $isUnsupportedForalError
            ? array_values(array_filter(array_map(
                static fn (string $paragraph): string => trim($paragraph),
                preg_split('/\R{2,}/u', trim((string) $domainError)) ?: []
            )))
            : [];
    @endphp

    <div class="mx-auto flex w-full max-w-6xl flex-col gap-6 px-4 py-6 md:px-8 md:py-10">
        <header class="irpf-panel rounded-3xl px-5 py-6 md:px-8">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[var(--irpf-teal)]">IRPF España</p>
                    <h1 class="irpf-display text-5xl leading-none text-[var(--irpf-ink)] md:text-7xl">Calculadora IRPF {{ $year }} por comunidades autónomas</h1>
                    <p class="mt-2 max-w-2xl text-sm text-[var(--irpf-muted)] md:text-base">
                        Simula de forma orientativa tu cuota de IRPF para {{ $year }} en {{ $regionOptions[$regionSlug] ?? 'una comunidad no válida' }}.
                    </p>
                </div>
                <flux:badge color="cyan" size="sm">Régimen común</flux:badge>
            </div>
        </header>

        <main class="grid gap-6 lg:grid-cols-[1fr_1.15fr]">
            <section class="irpf-panel rounded-3xl p-5 md:p-7">
                <flux:heading size="xl" class="irpf-display text-4xl text-[var(--irpf-ink)] md:text-5xl">Introduce tus datos</flux:heading>
                <flux:text class="mt-2 text-sm text-[var(--irpf-muted)]">Completa estos campos para obtener un cálculo aproximado.</flux:text>

                <form wire:submit="calculate" class="mt-5 space-y-4">
                    <article class="irpf-soft-card rounded-2xl p-4">
                        <flux:heading size="sm">Datos principales</flux:heading>
                        <div class="mt-3 space-y-3">
                            <flux:field>
                                <flux:label>Año fiscal</flux:label>
                                <div
                                    x-data="{ open: false }"
                                    class="irpf-region-dropdown relative w-full"
                                    @keydown.escape.window="open = false"
                                >
                                    <button
                                        type="button"
                                        class="irpf-region-trigger flex h-10 w-full items-center justify-between rounded-lg px-3 text-left text-sm"
                                        @click="open = ! open"
                                        :aria-expanded="open ? 'true' : 'false'"
                                        aria-haspopup="listbox"
                                    >
                                        <span>{{ $year }}</span>
                                        <flux:icon.chevron-down class="size-4 transition" x-bind:class="open ? 'rotate-180' : ''" />
                                    </button>

                                    <div
                                        x-cloak
                                        x-show="open"
                                        x-transition.origin.top
                                        @click.outside="open = false"
                                        class="irpf-region-menu absolute top-[calc(100%+0.4rem)] left-0 z-40 w-full overflow-auto rounded-lg p-[.3125rem]"
                                        role="listbox"
                                    >
                                        @foreach ([2025, 2026] as $yearOption)
                                            <button
                                                type="button"
                                                wire:key="year-option-{{ $yearOption }}"
                                                wire:click="selectYear({{ $yearOption }})"
                                                @click="open = false"
                                                class="{{ $year === $yearOption ? 'irpf-region-option-active' : 'irpf-region-option' }} flex w-full items-center rounded-md px-2 py-1.5 text-left text-sm font-medium"
                                            >
                                                {{ $yearOption }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                                <flux:error name="year" />
                            </flux:field>

                            <flux:field>
                                <flux:label>Comunidad autónoma</flux:label>
                                <div
                                    x-data="{ open: false }"
                                    class="irpf-region-dropdown relative w-full"
                                    @keydown.escape.window="open = false"
                                >
                                    <button
                                        type="button"
                                        class="irpf-region-trigger flex h-10 w-full items-center justify-between rounded-lg px-3 text-left text-sm"
                                        @click="open = ! open"
                                        :aria-expanded="open ? 'true' : 'false'"
                                        aria-haspopup="listbox"
                                    >
                                        <span>{{ $regionOptions[$regionSlug] ?? 'Selecciona una comunidad' }}</span>
                                        <flux:icon.chevron-down class="size-4 transition" x-bind:class="open ? 'rotate-180' : ''" />
                                    </button>

                                    <div
                                        x-cloak
                                        x-show="open"
                                        x-transition.origin.top
                                        @click.outside="open = false"
                                        class="irpf-region-menu absolute top-[calc(100%+0.4rem)] left-0 z-40 max-h-64 w-full overflow-auto rounded-lg p-[.3125rem]"
                                        role="listbox"
                                    >
                                        @foreach ($regionOptions as $slug => $label)
                                            <button
                                                type="button"
                                                wire:key="region-option-{{ $slug }}"
                                                wire:click="selectRegion('{{ $slug }}')"
                                                @click="open = false"
                                                class="{{ $regionSlug === $slug ? 'irpf-region-option-active' : 'irpf-region-option' }} flex w-full items-center rounded-md px-2 py-1.5 text-left text-sm font-medium"
                                            >
                                                {{ $label }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                                <flux:error name="regionSlug" />
                                <p class="mt-1 text-xs text-[var(--irpf-muted)]">
                                    Navarra y País Vasco tienen régimen fiscal propio; los cálculos aquí son solo para régimen común.
                                </p>
                            </flux:field>

                            <flux:field>
                                <flux:label>Ingresos brutos anuales (EUR)</flux:label>
                                <flux:input type="number" min="1" step="1" wire:model="grossIncome" placeholder="Ejemplo: 30.000" />
                                <flux:error name="grossIncome" />
                            </flux:field>
                        </div>
                    </article>

                    <article class="irpf-soft-card rounded-2xl p-4">
                        <flux:heading size="sm">Situación familiar</flux:heading>
                        <div class="mt-3 space-y-3">
                            <flux:field>
                                <flux:label>Número de hijos</flux:label>
                                <flux:input type="number" min="0" step="1" wire:model="children" />
                                <flux:error name="children" />
                            </flux:field>

                            <div class="rounded-xl border border-dashed border-[var(--irpf-line)] px-3 py-2 text-xs text-[var(--irpf-muted)]">
                                Próximamente: discapacidad, ascendientes y otros factores familiares.
                            </div>
                        </div>
                    </article>

                    <article class="irpf-soft-card rounded-2xl p-4">
                        <flux:heading size="sm">Deducciones y ajustes</flux:heading>
                        <div class="mt-3 space-y-3">
                            @if ($regionSlug === 'ceuta_melilla')
                                <p class="text-sm text-[var(--irpf-muted)]">
                                    Bonificación Ceuta/Melilla activa: se aplica automáticamente una deducción del 60% sobre la cuota.
                                </p>
                            @else
                                <p class="text-sm text-[var(--irpf-muted)]">
                                    La bonificación Ceuta/Melilla (60%) se aplica automáticamente al seleccionar
                                    <strong class="text-[var(--irpf-ink)]">Ceuta y Melilla (bonificación 60%)</strong>
                                    como comunidad.
                                </p>
                            @endif
                            <p class="text-xs text-[var(--irpf-muted)]">
                                El resto de deducciones avanzadas se incorporará en versiones posteriores.
                            </p>
                        </div>
                    </article>

                    <div
                        x-data="{
                            copied: false,
                            copyError: false,
                            async copyCurrentLink() {
                                this.copyError = false;

                                try {
                                    await navigator.clipboard.writeText(window.location.href);
                                    if (typeof window.gtag === 'function') {
                                        window.gtag('event', 'copy_link', {
                                            year: $wire.year,
                                            region_slug: $wire.regionSlug,
                                            gross_income: $wire.grossIncome,
                                            children: $wire.children,
                                        });
                                    }

                                    this.copied = true;
                                    setTimeout(() => {
                                        this.copied = false;
                                    }, 2200);
                                } catch (error) {
                                    this.copyError = true;
                                    setTimeout(() => {
                                        this.copyError = false;
                                    }, 2600);
                                }
                            }
                        }"
                        class="flex flex-wrap items-center gap-3 pt-1"
                    >
                        <flux:button type="submit" variant="primary" class="data-loading:opacity-60">
                            Calcular IRPF
                        </flux:button>

                        <flux:button type="button" variant="ghost" @click="copyCurrentLink">
                            Copiar enlace
                        </flux:button>

                        <p x-cloak x-show="copied" x-transition.opacity.duration.250ms class="text-xs font-medium text-[var(--irpf-teal)]">
                            Enlace copiado
                        </p>
                        <p x-cloak x-show="copyError" x-transition.opacity.duration.250ms class="text-xs font-medium text-[var(--irpf-amber)]">
                            No se pudo copiar automáticamente
                        </p>
                    </div>
                </form>

                <p class="mt-4 text-xs text-[var(--irpf-muted)]">
                    Resultado orientativo para fines informativos. No constituye asesoría fiscal profesional.
                </p>
            </section>

            <section class="irpf-panel rounded-3xl p-5 md:p-7">
                <flux:heading size="xl" class="irpf-display text-4xl text-[var(--irpf-ink)] md:text-5xl">Resultado</flux:heading>
                <flux:text class="mt-2 text-sm text-[var(--irpf-muted)]">Resumen fiscal y detalle de cálculo.</flux:text>

                <flux:callout color="red" icon="exclamation-triangle" class="mt-4 rounded-2xl {{ $domainError === null ? 'hidden' : '' }}">
                    <flux:callout.heading>{{ $isUnsupportedForalError ? 'Régimen foral no incluido por ahora' : 'Error de cálculo' }}</flux:callout.heading>
                    @if ($isUnsupportedForalError)
                        <flux:callout.text class="space-y-2">
                            @foreach ($foralErrorParagraphs as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        </flux:callout.text>
                    @else
                        <flux:callout.text>{{ $domainError }}</flux:callout.text>
                    @endif
                </flux:callout>

                <flux:callout color="amber" icon="shield-exclamation" class="mt-4 rounded-2xl">
                    <flux:callout.heading>Aviso importante</flux:callout.heading>
                    <flux:callout.text>
                        Esta calculadora ofrece un cálculo aproximado del IRPF con fines informativos y educativos.
                        No constituye asesoría fiscal profesional. Para decisiones relevantes, consulta con una persona profesional o con la Agencia Tributaria.
                    </flux:callout.text>
                </flux:callout>

                <flux:callout color="amber" icon="information-circle" class="mt-5 rounded-2xl {{ $hasResult ? 'hidden' : '' }}">
                    <flux:callout.heading>Introduce tus datos y calcula</flux:callout.heading>
                    <flux:callout.text>Verás aquí el resumen y el detalle orientativo del cálculo.</flux:callout.text>
                </flux:callout>

                <div class="{{ $hasResult ? '' : 'hidden' }}">
                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        <article class="irpf-soft-card rounded-2xl p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[var(--irpf-muted)]">Ingresos brutos</p>
                            <p class="mt-2 text-2xl font-semibold text-[var(--irpf-ink)]">{{ number_format($grossIncomeEur, 2, ',', '.') }} EUR</p>
                        </article>
                        <article class="irpf-soft-card rounded-2xl p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[var(--irpf-muted)]">Mínimo personal + familiar</p>
                            <p class="mt-2 text-2xl font-semibold text-[var(--irpf-ink)]">{{ number_format($personalMinimumEur + $familyMinimumEur, 2, ',', '.') }} EUR</p>
                        </article>
                        <article class="irpf-soft-card rounded-2xl p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[var(--irpf-muted)]">Base liquidable</p>
                            <p class="mt-2 text-2xl font-semibold text-[var(--irpf-ink)]">{{ number_format($netTaxableBaseEur, 2, ',', '.') }} EUR</p>
                        </article>
                        <article class="irpf-soft-card rounded-2xl p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[var(--irpf-muted)]">Cuota total</p>
                            <p class="mt-2 text-2xl font-semibold text-[var(--irpf-amber)]">{{ number_format($totalTaxEur, 2, ',', '.') }} EUR</p>
                        </article>
                        <article class="irpf-soft-card rounded-2xl p-4 sm:col-span-2">
                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[var(--irpf-muted)]">Tipo efectivo</p>
                            <p class="mt-2 text-2xl font-semibold text-[var(--irpf-teal)]">{{ number_format($effectiveRatePercent, 2, ',', '.') }}%</p>
                        </article>
                    </div>

                    <div class="mt-5">
                        <p class="mb-2 text-sm font-medium text-[var(--irpf-muted)]">Ver detalle del cálculo</p>

                        <details class="irpf-soft-card rounded-2xl p-4">
                            <summary data-breakdown-summary class="cursor-pointer text-sm font-semibold text-[var(--irpf-ink)]">Detalle de mínimos</summary>
                            <div class="mt-3 grid gap-2 text-sm text-[var(--irpf-muted)]">
                                <p>Mínimo personal: <strong class="text-[var(--irpf-ink)]">{{ number_format($personalMinimumEur, 2, ',', '.') }} EUR</strong></p>
                                <p>Mínimo familiar: <strong class="text-[var(--irpf-ink)]">{{ number_format($familyMinimumEur, 2, ',', '.') }} EUR</strong></p>
                            </div>
                        </details>

                        <details class="irpf-soft-card mt-3 rounded-2xl p-4">
                            <summary data-breakdown-summary class="cursor-pointer text-sm font-semibold text-[var(--irpf-ink)]">Detalle de cuota estatal y autonómica</summary>
                            <div class="mt-3 grid gap-2 text-sm text-[var(--irpf-muted)]">
                                <p>Cuota estatal: <strong class="text-[var(--irpf-ink)]">{{ number_format($stateTaxEur, 2, ',', '.') }} EUR</strong></p>
                                <p>Cuota autonómica: <strong class="text-[var(--irpf-ink)]">{{ number_format($regionalTaxEur, 2, ',', '.') }} EUR</strong></p>
                                <p>Cuota antes de bonificación Ceuta/Melilla: <strong class="text-[var(--irpf-ink)]">{{ number_format($grossTaxEur, 2, ',', '.') }} EUR</strong></p>
                                @if ($ceutaMelillaDeductionEur > 0)
                                    <p>Bonificación Ceuta/Melilla (60%): <strong class="text-[var(--irpf-teal)]">-{{ number_format($ceutaMelillaDeductionEur, 2, ',', '.') }} EUR</strong></p>
                                @endif
                                <p>Cuota total a pagar: <strong class="text-[var(--irpf-amber)]">{{ number_format($totalTaxEur, 2, ',', '.') }} EUR</strong></p>
                                <p class="pt-1 text-xs text-[var(--irpf-muted)]">
                                    Nota: esta bonificación se muestra con una simplificación del 60% sobre la cuota agregada.
                                </p>
                            </div>
                        </details>

                        <details class="irpf-soft-card mt-3 rounded-2xl p-4">
                            <summary data-breakdown-summary class="cursor-pointer text-sm font-semibold text-[var(--irpf-ink)]">Tramos aplicados</summary>
                            <div class="mt-3 grid gap-2 text-sm text-[var(--irpf-muted)]">
                                <p>Tramos estatales aplicados: <strong class="text-[var(--irpf-ink)]">{{ $stateBracketsCount }}</strong></p>
                                <p>Tramos autonómicos aplicados: <strong class="text-[var(--irpf-ink)]">{{ $regionalBracketsCount }}</strong></p>
                            </div>
                        </details>
                    </div>
                </div>
            </section>
        </main>

        <section class="ad-slot irpf-soft-card min-h-32 rounded-3xl p-5" aria-label="Espacio para anuncios">
            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[var(--irpf-muted)]">Espacio para anuncios</p>
            <p class="mt-2 text-sm text-[var(--irpf-muted)]">
                Zona reservada para futuras integraciones publicitarias, sin afectar el contenido principal de la calculadora.
            </p>
        </section>
    </div>
</div>

<script>
    (() => {
        if (window.__irpfAnalyticsBound) {
            return;
        }

        window.__irpfAnalyticsBound = true;

        window.addEventListener('irpf-calculated', (event) => {
            if (typeof window.gtag !== 'function') {
                return;
            }

            const detail = event.detail ?? {};

            window.gtag('event', 'calculate_irpf', {
                year: detail.year ?? null,
                region_slug: detail.regionSlug ?? null,
                gross_income: detail.grossIncome ?? null,
                children: detail.children ?? null,
                total_tax: detail.totalTax ?? null,
                effective_rate: detail.effectiveRate ?? null,
            });
        });

        document.addEventListener('click', (event) => {
            if (window.__irpfBreakdownTracked) {
                return;
            }

            const summaryElement = event.target.closest('summary[data-breakdown-summary]');

            if (!summaryElement) {
                return;
            }

            requestAnimationFrame(() => {
                const detailsElement = summaryElement.closest('details');

                if (!detailsElement || !detailsElement.open || window.__irpfBreakdownTracked) {
                    return;
                }

                window.__irpfBreakdownTracked = true;

                if (typeof window.gtag !== 'function') {
                    return;
                }

                window.gtag('event', 'view_breakdown', {
                    year: @json($year),
                    region_slug: @json($regionSlug),
                });
            });
        }, true);
    })();
</script>
