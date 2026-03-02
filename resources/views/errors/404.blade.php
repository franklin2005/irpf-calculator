<x-layouts.app
    title="P&aacute;gina no encontrada - Calculadora IRPF Espa&ntilde;a"
    meta-description="La p&aacute;gina solicitada no existe o fue movida. Vuelve al inicio de la calculadora IRPF."
    :canonical="url()->current()"
>
    <main class="irpf-app-bg min-h-screen px-4 py-12 md:px-8">
        <section class="mx-auto w-full max-w-3xl irpf-panel rounded-3xl p-8 text-center md:p-10">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[var(--irpf-teal)]">Error 404</p>
            <h1 class="irpf-display mt-3 text-5xl text-[var(--irpf-ink)] md:text-6xl">P&aacute;gina no encontrada</h1>
            <p class="mt-4 text-sm text-[var(--irpf-muted)] md:text-base">
                La ruta que buscas no existe o ya no est&aacute; disponible.
            </p>

            <div class="mt-6 flex justify-center">
                <flux:button :href="route('home', [], false)" variant="primary">Volver al inicio</flux:button>
            </div>
        </section>
    </main>
</x-layouts.app>