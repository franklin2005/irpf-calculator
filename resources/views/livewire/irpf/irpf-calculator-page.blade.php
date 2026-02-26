<div wire:replace.self class="irpf-app-bg min-h-screen">
    @php
        $hasResult = $resultData !== null;
        $grossIncomeEur = $resultData['gross_income_eur'] ?? 0;
        $netTaxableBaseEur = $resultData['net_taxable_base_eur'] ?? 0;
        $totalTaxEur = $resultData['total_tax_eur'] ?? 0;
        $effectiveRatePercent = $resultData['effective_rate_percent'] ?? 0;
        $personalMinimumEur = $resultData['personal_minimum_eur'] ?? 0;
        $familyMinimumEur = $resultData['family_minimum_eur'] ?? 0;
        $stateTaxEur = $resultData['state_tax_eur'] ?? 0;
        $regionalTaxEur = $resultData['regional_tax_eur'] ?? 0;
        $stateBracketsCount = $resultData['state_brackets_applied_count'] ?? 0;
        $regionalBracketsCount = $resultData['regional_brackets_applied_count'] ?? 0;
    @endphp

    <div class="mx-auto flex w-full max-w-6xl flex-col gap-6 px-4 py-6 md:px-8 md:py-10">
        <header class="irpf-panel rounded-3xl px-5 py-6 md:px-8">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[var(--irpf-teal)]">MVP Livewire + Flux</p>
                    <h1 class="irpf-display text-5xl leading-none text-[var(--irpf-ink)] md:text-7xl">Calculadora IRPF</h1>
                    <p class="mt-2 max-w-2xl text-sm text-[var(--irpf-muted)] md:text-base">
                        Simulacion inicial para {{ $year }} en {{ $region }}, conectada al motor de dominio.
                    </p>
                    <div class="mt-3 flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.14em]">
                        <span class="text-[var(--irpf-muted)]">Ano:</span>
                        <a
                            href="{{ route('irpf.calculator', ['year' => 2025]) }}"
                            class="rounded-md border px-2 py-1 transition {{ $year === 2025 ? 'border-[var(--irpf-teal)] text-[var(--irpf-teal)]' : 'border-[var(--irpf-line)] text-[var(--irpf-muted)] hover:text-[var(--irpf-ink)]' }}"
                        >
                            2025
                        </a>
                        <a
                            href="{{ route('irpf.calculator', ['year' => 2026]) }}"
                            class="rounded-md border px-2 py-1 transition {{ $year === 2026 ? 'border-[var(--irpf-teal)] text-[var(--irpf-teal)]' : 'border-[var(--irpf-line)] text-[var(--irpf-muted)] hover:text-[var(--irpf-ink)]' }}"
                        >
                            2026
                        </a>
                    </div>
                </div>
                <flux:badge color="cyan" size="sm">EPIC 5 UI MVP</flux:badge>
            </div>
        </header>

        <flux:callout color="red" icon="exclamation-triangle" class="rounded-2xl {{ $domainError === null ? 'hidden' : '' }}">
            <flux:callout.heading>Error de calculo</flux:callout.heading>
            <flux:callout.text>{{ $domainError }}</flux:callout.text>
        </flux:callout>

        <main class="grid gap-6 lg:grid-cols-[1fr_1.15fr]">
            <section class="irpf-panel rounded-3xl p-5 md:p-7">
                <flux:heading size="xl" class="irpf-display text-4xl text-[var(--irpf-ink)] md:text-5xl">Introduce tus datos</flux:heading>
                <flux:text class="mt-2 text-sm text-[var(--irpf-muted)]">Rellena los datos base para obtener una estimacion.</flux:text>

                <form wire:submit="calculate" class="mt-5 space-y-4">
                    <article class="irpf-soft-card rounded-2xl p-4">
                        <flux:heading size="sm">Datos principales</flux:heading>
                        <div class="mt-3 space-y-3">
                            <flux:field>
                                <flux:label>Ano fiscal</flux:label>
                                <flux:input value="{{ $year }}" readonly />
                            </flux:field>

                            <flux:field>
                                <flux:label>CCAA</flux:label>
                                <flux:input value="{{ $region }}" readonly />
                            </flux:field>

                            <flux:field>
                                <flux:label>Ingresos brutos anuales (EUR)</flux:label>
                                <flux:input type="number" min="1" step="1" wire:model="grossIncome" placeholder="Ejemplo: 30000" />
                                <flux:error name="grossIncome" />
                            </flux:field>
                        </div>
                    </article>

                    <article class="irpf-soft-card rounded-2xl p-4">
                        <flux:heading size="sm">Familia</flux:heading>
                        <div class="mt-3 space-y-3">
                            <flux:field>
                                <flux:label>Numero de hijos</flux:label>
                                <flux:input type="number" min="0" step="1" wire:model="children" />
                                <flux:error name="children" />
                            </flux:field>

                            <div class="rounded-xl border border-dashed border-[var(--irpf-line)] px-3 py-2 text-xs text-[var(--irpf-muted)]">
                                Proximamente: discapacidad, ascendientes y otros factores familiares.
                            </div>
                        </div>
                    </article>

                    <article class="irpf-soft-card rounded-2xl p-4">
                        <flux:heading size="sm">Deducciones (MVP)</flux:heading>
                        <p class="mt-3 text-sm text-[var(--irpf-muted)]">
                            Las deducciones avanzadas se incorporaran en versiones posteriores. En este MVP no se aplican.
                        </p>
                    </article>

                    <div
                        x-data="{
                            copied: false,
                            copyError: false,
                            async copyCurrentLink() {
                                this.copyError = false;

                                try {
                                    await navigator.clipboard.writeText(window.location.href);
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
                            No se pudo copiar automaticamente
                        </p>
                    </div>
                </form>

                <p class="mt-4 text-xs text-[var(--irpf-muted)]">
                    Simulador en desarrollo con tablas y supuestos simplificados para fines educativos.
                </p>
            </section>

            <section class="irpf-panel rounded-3xl p-5 md:p-7">
                <flux:heading size="xl" class="irpf-display text-4xl text-[var(--irpf-ink)] md:text-5xl">Resultado</flux:heading>
                <flux:text class="mt-2 text-sm text-[var(--irpf-muted)]">Resumen fiscal y detalle de calculo.</flux:text>

                <flux:callout color="amber" icon="shield-exclamation" class="mt-4 rounded-2xl">
                    <flux:callout.heading>Aviso importante</flux:callout.heading>
                    <flux:callout.text>
                        Esta calculadora ofrece un calculo aproximado del IRPF con fines informativos y educativos.
                        No constituye asesoria fiscal profesional. Para decisiones importantes, consulta con una persona profesional o la Agencia Tributaria.
                    </flux:callout.text>
                </flux:callout>

                <flux:callout color="amber" icon="information-circle" class="mt-5 rounded-2xl {{ $hasResult ? 'hidden' : '' }}">
                    <flux:callout.heading>Introduce tus datos y calcula</flux:callout.heading>
                    <flux:callout.text>Veras aqui el resumen y el detalle orientativo del calculo.</flux:callout.text>
                </flux:callout>

                <div class="{{ $hasResult ? '' : 'hidden' }}">
                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        <article class="irpf-soft-card rounded-2xl p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[var(--irpf-muted)]">Ingresos brutos</p>
                            <p class="mt-2 text-2xl font-semibold text-[var(--irpf-ink)]">{{ number_format($grossIncomeEur, 2, ',', '.') }} EUR</p>
                        </article>
                        <article class="irpf-soft-card rounded-2xl p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[var(--irpf-muted)]">Minimo personal + familiar</p>
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
                        <p class="mb-2 text-sm font-medium text-[var(--irpf-muted)]">Ver detalle del calculo</p>

                        <details class="irpf-soft-card rounded-2xl p-4">
                            <summary class="cursor-pointer text-sm font-semibold text-[var(--irpf-ink)]">Detalle minimos</summary>
                            <div class="mt-3 grid gap-2 text-sm text-[var(--irpf-muted)]">
                                <p>Minimo personal: <strong class="text-[var(--irpf-ink)]">{{ number_format($personalMinimumEur, 2, ',', '.') }} EUR</strong></p>
                                <p>Minimo familiar: <strong class="text-[var(--irpf-ink)]">{{ number_format($familyMinimumEur, 2, ',', '.') }} EUR</strong></p>
                            </div>
                        </details>

                        <details class="irpf-soft-card mt-3 rounded-2xl p-4">
                            <summary class="cursor-pointer text-sm font-semibold text-[var(--irpf-ink)]">Detalle cuota estatal/autonomica</summary>
                            <div class="mt-3 grid gap-2 text-sm text-[var(--irpf-muted)]">
                                <p>Cuota estatal: <strong class="text-[var(--irpf-ink)]">{{ number_format($stateTaxEur, 2, ',', '.') }} EUR</strong></p>
                                <p>Cuota autonomica: <strong class="text-[var(--irpf-ink)]">{{ number_format($regionalTaxEur, 2, ',', '.') }} EUR</strong></p>
                            </div>
                        </details>

                        <details class="irpf-soft-card mt-3 rounded-2xl p-4">
                            <summary class="cursor-pointer text-sm font-semibold text-[var(--irpf-ink)]">Tramos aplicados</summary>
                            <div class="mt-3 grid gap-2 text-sm text-[var(--irpf-muted)]">
                                <p>Tramos estatales aplicados: <strong class="text-[var(--irpf-ink)]">{{ $stateBracketsCount }}</strong></p>
                                <p>Tramos autonomicos aplicados: <strong class="text-[var(--irpf-ink)]">{{ $regionalBracketsCount }}</strong></p>
                            </div>
                        </details>
                    </div>
                </div>
            </section>
        </main>

        <!-- Reserva de altura para evitar CLS cuando se carguen anuncios en futuras integraciones -->
        <section class="ad-slot irpf-soft-card min-h-32 rounded-3xl p-5" aria-label="Espacio para anuncios">
            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[var(--irpf-muted)]">Espacio para anuncios</p>
            <p class="mt-2 text-sm text-[var(--irpf-muted)]">
                Zona reservada para integraciones futuras de publicidad (Google Ads u otros), sin scripts de terceros en este MVP.
            </p>
        </section>
    </div>
</div>
