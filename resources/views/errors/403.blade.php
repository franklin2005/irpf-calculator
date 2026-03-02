<x-layouts.app
    title="Acceso denegado - Calculadora de IRPF España"
    meta-description="No tienes permisos para acceder a este recurso."
    :canonical="url()->current()"
>
    <main class="irpf-app-bg min-h-screen px-4 py-12 md:px-8">
        <section class="mx-auto w-full max-w-3xl irpf-panel rounded-3xl p-8 text-center md:p-10">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[var(--irpf-teal)]">Error 403</p>
            <h1 class="irpf-display mt-3 text-5xl text-[var(--irpf-ink)] md:text-6xl">Acceso denegado</h1>
            <p class="mt-4 text-sm text-[var(--irpf-muted)] md:text-base">
                No tienes permisos para ver esta página.
            </p>

            <div class="mt-6 flex justify-center">
                <flux:button :href="route('home', [], false)" variant="primary">Volver al inicio</flux:button>
            </div>
        </section>
    </main>
</x-layouts.app>
