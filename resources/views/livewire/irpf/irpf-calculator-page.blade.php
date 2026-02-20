<div wire:replace.self class="irpf-app-bg min-h-screen">
    <div class="mx-auto flex w-full max-w-6xl flex-col gap-6 px-4 py-6 md:px-8 md:py-10">
        <header class="irpf-panel rounded-3xl px-5 py-6 md:px-8">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[var(--irpf-teal)]">MVP Livewire + Flux</p>
                    <h1 class="irpf-display text-5xl leading-none text-[var(--irpf-ink)] md:text-7xl">Calculadora IRPF</h1>
                    <p class="mt-2 max-w-2xl text-sm text-[var(--irpf-muted)] md:text-base">
                        Simulacion inicial para {{ $year }} en {{ $region }}, conectada al motor de dominio.
                    </p>
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
                <flux:heading size="xl" class="irpf-display text-4xl text-[var(--irpf-ink)] md:text-5xl">Datos de entrada</flux:heading>
                <flux:text class="mt-2 text-sm text-[var(--irpf-muted)]">Rellena tus datos y calcula el resultado estimado.</flux:text>

                <form wire:submit="calculate" class="mt-5 space-y-4">
                    <flux:field>
                        <flux:label>Ano</flux:label>
                        <flux:input value="{{ $year }}" readonly />
                    </flux:field>

                    <flux:field>
                        <flux:label>CCAA</flux:label>
                        <flux:input value="{{ $region }}" disabled />
                    </flux:field>

                    <flux:field>
                        <flux:label>Ingresos brutos anuales (EUR)</flux:label>
                        <flux:input type="number" min="1" step="1" wire:model="grossIncome" placeholder="Ejemplo: 30000" />
                        <flux:error name="grossIncome" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Numero de hijos</flux:label>
                        <flux:input type="number" min="0" step="1" wire:model="children" />
                        <flux:error name="children" />
                    </flux:field>

                    <div class="flex items-center gap-3 pt-2">
                        <flux:button type="submit" variant="primary" class="data-loading:opacity-60">
                            Calcular IRPF
                        </flux:button>
                    </div>
                </form>
            </section>

            <section class="irpf-panel rounded-3xl p-5 md:p-7">
                <flux:heading size="xl" class="irpf-display text-4xl text-[var(--irpf-ink)] md:text-5xl">Resultado</flux:heading>
                <flux:text class="mt-2 text-sm text-[var(--irpf-muted)]">Resumen fiscal y detalle de tramos aplicados.</flux:text>

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

                <flux:callout color="amber" icon="information-circle" class="mt-5 rounded-2xl {{ $hasResult ? 'hidden' : '' }}">
                    <flux:callout.heading>Introduce tus datos y calcula</flux:callout.heading>
                    <flux:callout.text>
                        Veras aqui la base liquidable, cuota total, tipo efectivo y el detalle de minimos y tramos.
                    </flux:callout.text>
                </flux:callout>

                <div class="{{ $hasResult ? '' : 'hidden' }}">
                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        <article class="irpf-soft-card rounded-2xl p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[var(--irpf-muted)]">Ingresos brutos</p>
                            <p class="mt-2 text-2xl font-semibold text-[var(--irpf-ink)]">
                                {{ number_format($grossIncomeEur, 2, ',', '.') }} EUR
                            </p>
                        </article>
                        <article class="irpf-soft-card rounded-2xl p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[var(--irpf-muted)]">Base liquidable</p>
                            <p class="mt-2 text-2xl font-semibold text-[var(--irpf-ink)]">
                                {{ number_format($netTaxableBaseEur, 2, ',', '.') }} EUR
                            </p>
                        </article>
                        <article class="irpf-soft-card rounded-2xl p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[var(--irpf-muted)]">Cuota total</p>
                            <p class="mt-2 text-2xl font-semibold text-[var(--irpf-amber)]">
                                {{ number_format($totalTaxEur, 2, ',', '.') }} EUR
                            </p>
                        </article>
                        <article class="irpf-soft-card rounded-2xl p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[var(--irpf-muted)]">Tipo efectivo</p>
                            <p class="mt-2 text-2xl font-semibold text-[var(--irpf-teal)]">
                                {{ number_format($effectiveRatePercent, 2, ',', '.') }}%
                            </p>
                        </article>
                    </div>

                    <div class="irpf-soft-card mt-5 space-y-3 rounded-2xl p-4">
                        <flux:heading size="lg">Detalle</flux:heading>
                        <div class="grid gap-3 text-sm text-[var(--irpf-ink)] md:grid-cols-2">
                            <p>Minimo personal: <strong>{{ number_format($personalMinimumEur, 2, ',', '.') }} EUR</strong></p>
                            <p>Minimo familiar: <strong>{{ number_format($familyMinimumEur, 2, ',', '.') }} EUR</strong></p>
                            <p>Cuota estatal: <strong>{{ number_format($stateTaxEur, 2, ',', '.') }} EUR</strong></p>
                            <p>Cuota autonomica: <strong>{{ number_format($regionalTaxEur, 2, ',', '.') }} EUR</strong></p>
                            <p>Tramos estatales aplicados: <strong>{{ $stateBracketsCount }}</strong></p>
                            <p>Tramos autonomicos aplicados: <strong>{{ $regionalBracketsCount }}</strong></p>
                        </div>
                    </div>

                    <div class="irpf-soft-card mt-4 rounded-2xl p-4">
                        <flux:heading size="sm">Tramos aplicados (resumen)</flux:heading>
                        <div class="mt-3 grid gap-2 text-sm text-[var(--irpf-ink)] md:grid-cols-2">
                            <p>Estatales aplicados: <strong>{{ $stateBracketsCount }}</strong></p>
                            <p>Autonomicos aplicados: <strong>{{ $regionalBracketsCount }}</strong></p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</div>
