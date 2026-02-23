<x-layouts.app
    title="Error interno del servidor - Calculadora IRPF Espana"
    meta-description="Se produjo un error interno del servidor. Intenta de nuevo en unos minutos."
    :canonical="url()->current()"
>
    <main class="irpf-app-bg min-h-screen px-4 py-12 md:px-8">
        <section class="mx-auto w-full max-w-3xl irpf-panel rounded-3xl p-8 text-center md:p-10">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[var(--irpf-teal)]">Error 500</p>
            <h1 class="irpf-display mt-3 text-5xl text-[var(--irpf-ink)] md:text-6xl">Error interno del servidor</h1>
            <p class="mt-4 text-sm text-[var(--irpf-muted)] md:text-base">
                Ha ocurrido un problema inesperado. Intenta recargar mas tarde.
            </p>

            <div class="mt-6 flex justify-center">
                <flux:button :href="route('home')" variant="primary">Volver a Home</flux:button>
            </div>
        </section>
    </main>
</x-layouts.app>
