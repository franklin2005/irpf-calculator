<x-layouts.app title="Calculadora IRPF 2026">
    <main class="irpf-app-bg min-h-screen">
        <div class="mx-auto w-full max-w-6xl px-4 py-10 md:px-8 md:py-14">
            <section class="irpf-panel rounded-3xl px-6 py-10 text-center md:px-10">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[var(--irpf-teal)]">IRPF MVP</p>
                <h1 class="irpf-display mt-3 text-5xl leading-none text-[var(--irpf-ink)] md:text-7xl">Calculadora IRPF 2026 para Espana</h1>
                <p class="mx-auto mt-4 max-w-2xl text-sm text-[var(--irpf-muted)] md:text-base">
                    Simula tu resultado fiscal anual de forma orientativa para 2026 con un flujo simple, rapido y claro.
                </p>
                <div class="mt-7 flex justify-center">
                    <flux:button :href="route('irpf.calculator', ['year' => 2026])" variant="primary" wire:navigate>
                        Ir a la calculadora
                    </flux:button>
                </div>
            </section>

            <section class="mt-6 grid gap-6 lg:grid-cols-3">
                <article class="irpf-soft-card rounded-3xl p-5">
                    <flux:heading size="lg">Que incluye</flux:heading>
                    <ul class="mt-3 space-y-2 text-sm text-[var(--irpf-ink)]">
                        <li>Calculo estimado IRPF sobre ingresos brutos anuales.</li>
                        <li>Escenario del ano 2026.</li>
                        <li>CCAA inicial: Asturias.</li>
                        <li>Minimos personales y familiares simplificados.</li>
                        <li>Resumen de cuota estatal/autonomica y tipo efectivo.</li>
                    </ul>
                </article>

                <article class="irpf-soft-card rounded-3xl p-5">
                    <flux:heading size="lg">Que NO incluye</flux:heading>
                    <ul class="mt-3 space-y-2 text-sm text-[var(--irpf-ink)]">
                        <li>No sustituye asesoramiento fiscal profesional.</li>
                        <li>No cubre todos los supuestos especiales.</li>
                        <li>No incorpora todavia deducciones avanzadas.</li>
                        <li>No es un resultado oficial de la AEAT.</li>
                    </ul>
                </article>

                <article class="irpf-soft-card rounded-3xl p-5">
                    <flux:heading size="lg">Proximas guias</flux:heading>
                    <ul class="mt-3 space-y-2 text-sm">
                        <li><a href="#" class="text-[var(--irpf-teal)] transition hover:text-cyan-300">Guia tramos IRPF</a></li>
                        <li><a href="#" class="text-[var(--irpf-teal)] transition hover:text-cyan-300">Guia retenciones nomina</a></li>
                        <li><a href="#" class="text-[var(--irpf-teal)] transition hover:text-cyan-300">Guia minimos familiares</a></li>
                    </ul>
                </article>
            </section>
        </div>
    </main>
</x-layouts.app>
