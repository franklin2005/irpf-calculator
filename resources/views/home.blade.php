<x-layouts.app
    title="Calculadora IRPF 2026 para Espana - Explicacion y acceso"
    meta-description="Calculadora IRPF para Espana con calculo estimado de 2026, enfoque inicial en Asturias y explicacion del alcance del MVP."
    :canonical="route('home')"
>
    <main class="irpf-app-bg min-h-screen">
        <div class="mx-auto w-full max-w-6xl px-4 py-10 md:px-8 md:py-14">
            <section class="irpf-panel rounded-3xl px-6 py-10 text-center md:px-10">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[var(--irpf-teal)]">IRPF MVP</p>
                <h1 class="irpf-display mt-3 text-5xl leading-none text-[var(--irpf-ink)] md:text-7xl">Calculadora IRPF 2026 para Espana</h1>
                <h2 class="mx-auto mt-4 max-w-2xl text-sm font-medium text-[var(--irpf-muted)] md:text-base">
                    Simula tu resultado fiscal anual de forma orientativa para 2026 con un flujo simple, rapido y claro.
                </h2>
                <div class="mt-7 flex justify-center">
                    <flux:button :href="route('irpf.calculator', ['year' => 2026])" variant="primary" aria-label="Ir a la calculadora IRPF 2026" wire:navigate>
                        Ir a la calculadora
                    </flux:button>
                </div>
            </section>

            <!-- Reserva de altura para evitar CLS cuando se carguen anuncios en futuras integraciones -->
            <section class="ad-slot irpf-soft-card mt-6 min-h-28 rounded-3xl p-5" aria-label="Espacio para anuncios">
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[var(--irpf-muted)]">Espacio para anuncios</p>
                <p class="mt-2 text-sm text-[var(--irpf-muted)]">
                    Bloque reservado para integraciones futuras de publicidad (Google Ads u otros), sin scripts de terceros por ahora.
                </p>
            </section>

            <section class="mt-6 grid gap-6 lg:grid-cols-3">
                <article class="irpf-soft-card rounded-3xl p-5">
                    <h2 class="text-lg font-semibold text-[var(--irpf-ink)]">Que incluye</h2>
                    <ul class="mt-3 space-y-2 text-sm text-[var(--irpf-ink)]">
                        <li>Calculo estimado IRPF sobre ingresos brutos anuales.</li>
                        <li>Escenario del ano 2026.</li>
                        <li>CCAA inicial: Asturias.</li>
                        <li>Minimos personales y familiares simplificados.</li>
                        <li>Resumen de cuota estatal/autonomica y tipo efectivo.</li>
                    </ul>
                </article>

                <article class="irpf-soft-card rounded-3xl p-5">
                    <h2 class="text-lg font-semibold text-[var(--irpf-ink)]">Que NO incluye</h2>
                    <ul class="mt-3 space-y-2 text-sm text-[var(--irpf-ink)]">
                        <li>No sustituye asesoramiento fiscal profesional.</li>
                        <li>No cubre todos los supuestos especiales.</li>
                        <li>No incorpora todavia deducciones avanzadas.</li>
                        <li>No es un resultado oficial de la AEAT.</li>
                    </ul>
                </article>

                <article class="irpf-soft-card rounded-3xl p-5">
                    <h2 class="text-lg font-semibold text-[var(--irpf-ink)]">Proximas guias</h2>
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
