<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>IRPF UI Lab</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=Bebas+Neue&display=swap"
            rel="stylesheet"
        >

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <style>
            :root {
                --ui-bg: #f6efe2;
                --ui-ink: #1f2a22;
                --ui-panel: #fff9ef;
                --ui-line: #c8b69a;
                --ui-accent: #0f766e;
                --ui-hot: #d97706;
            }

            body {
                font-family: 'Sora', ui-sans-serif, system-ui, sans-serif;
                color: var(--ui-ink);
                background:
                    radial-gradient(1100px 700px at 100% 0%, rgb(15 118 110 / 18%), transparent 60%),
                    radial-gradient(900px 500px at 0% 100%, rgb(217 119 6 / 16%), transparent 55%),
                    var(--ui-bg);
            }

            .display-title {
                font-family: 'Bebas Neue', ui-sans-serif, system-ui, sans-serif;
                letter-spacing: 0.04em;
            }

            .panel {
                border: 1px solid var(--ui-line);
                background: var(--ui-panel);
                box-shadow: 0 16px 40px rgb(48 38 20 / 12%);
            }

            .metric-tile {
                border: 1px solid rgb(31 42 34 / 22%);
                background: linear-gradient(145deg, rgb(255 255 255 / 94%), rgb(255 247 232 / 86%));
            }

            .nav-link[data-current] {
                color: white;
                background: var(--ui-accent);
                border-color: var(--ui-accent);
            }
        </style>
    </head>

    <body class="min-h-screen antialiased">
        <div class="mx-auto w-full max-w-6xl px-5 py-6 md:px-8 md:py-10" x-data="{ gross: 42000, extras: 3500, children: 1, withholding: 18 }">
            <header class="panel rounded-3xl p-5 md:p-7">
                <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                    <div class="space-y-3">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-teal-700">IRPF Experience Layer</p>
                        <h1 class="display-title text-6xl leading-none text-zinc-900 md:text-8xl">Tax Studio</h1>
                        <p class="max-w-2xl text-sm text-zinc-700 md:text-base">
                            Interfaz experimental para visualizar tu escenario fiscal con feedback inmediato, pensada para una experiencia clara y rapida.
                        </p>
                    </div>

                    <nav class="flex flex-wrap gap-2">
                        <a
                            href="/"
                            wire:navigate
                            class="nav-link rounded-full border border-zinc-500/40 px-4 py-2 text-sm font-semibold text-zinc-800 transition hover:border-teal-700 hover:text-teal-800"
                        >
                            Inicio
                        </a>
                        <a
                            href="/ui"
                            wire:navigate
                            class="nav-link rounded-full border border-zinc-500/40 px-4 py-2 text-sm font-semibold text-zinc-800 transition hover:border-teal-700 hover:text-teal-800"
                        >
                            UI Lab
                        </a>
                    </nav>
                </div>
            </header>

            <main class="mt-6 grid gap-6 lg:grid-cols-[1.35fr_0.95fr]">
                <section class="panel rounded-3xl p-5 md:p-7">
                    <div class="mb-5 flex items-center justify-between">
                        <h2 class="display-title text-4xl text-zinc-900 md:text-5xl">Scenario Inputs</h2>
                        <span class="rounded-full border border-zinc-500/35 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-zinc-700">Live preview</span>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <label class="space-y-2">
                            <span class="text-xs font-semibold uppercase tracking-[0.16em] text-zinc-700">Gross annual income</span>
                            <input
                                type="range"
                                min="12000"
                                max="120000"
                                step="500"
                                x-model.number="gross"
                                class="w-full accent-teal-700"
                            >
                            <input
                                type="number"
                                min="12000"
                                max="120000"
                                step="500"
                                x-model.number="gross"
                                class="w-full rounded-2xl border border-zinc-500/35 bg-white/80 px-3 py-2 text-sm font-semibold outline-none ring-0 transition focus:border-teal-700"
                            >
                        </label>

                        <label class="space-y-2">
                            <span class="text-xs font-semibold uppercase tracking-[0.16em] text-zinc-700">Variable extras</span>
                            <input
                                type="range"
                                min="0"
                                max="30000"
                                step="250"
                                x-model.number="extras"
                                class="w-full accent-amber-700"
                            >
                            <input
                                type="number"
                                min="0"
                                max="30000"
                                step="250"
                                x-model.number="extras"
                                class="w-full rounded-2xl border border-zinc-500/35 bg-white/80 px-3 py-2 text-sm font-semibold outline-none ring-0 transition focus:border-amber-700"
                            >
                        </label>

                        <label class="space-y-2">
                            <span class="text-xs font-semibold uppercase tracking-[0.16em] text-zinc-700">Children</span>
                            <select
                                x-model.number="children"
                                class="w-full rounded-2xl border border-zinc-500/35 bg-white/80 px-3 py-2 text-sm font-semibold outline-none transition focus:border-teal-700"
                            >
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3+</option>
                            </select>
                        </label>

                        <label class="space-y-2">
                            <span class="text-xs font-semibold uppercase tracking-[0.16em] text-zinc-700">Current withholding %</span>
                            <input
                                type="range"
                                min="5"
                                max="35"
                                step="1"
                                x-model.number="withholding"
                                class="w-full accent-zinc-800"
                            >
                            <p class="rounded-2xl border border-zinc-500/35 bg-white/80 px-3 py-2 text-sm font-semibold">
                                <span x-text="withholding"></span>%
                            </p>
                        </label>
                    </div>
                </section>

                <aside class="space-y-6">
                    <section class="panel rounded-3xl p-5 md:p-6">
                        <h3 class="display-title text-3xl text-zinc-900">Quick Reading</h3>
                        <div class="mt-4 grid gap-3">
                            <article class="metric-tile rounded-2xl p-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.14em] text-zinc-600">Estimated taxable base</p>
                                <p class="mt-2 text-2xl font-bold text-zinc-900">
                                    <span x-text="new Intl.NumberFormat('es-ES', { style: 'currency', currency: 'EUR', maximumFractionDigits: 0 }).format(Math.max(gross + extras - (children * 1800), 0))"></span>
                                </p>
                            </article>
                            <article class="metric-tile rounded-2xl p-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.14em] text-zinc-600">Projected annual withholding</p>
                                <p class="mt-2 text-2xl font-bold text-teal-800">
                                    <span x-text="new Intl.NumberFormat('es-ES', { style: 'currency', currency: 'EUR', maximumFractionDigits: 0 }).format(((gross + extras) * (withholding / 100)))"></span>
                                </p>
                            </article>
                            <article class="metric-tile rounded-2xl p-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.14em] text-zinc-600">Net before final settlement</p>
                                <p class="mt-2 text-2xl font-bold text-amber-700">
                                    <span x-text="new Intl.NumberFormat('es-ES', { style: 'currency', currency: 'EUR', maximumFractionDigits: 0 }).format((gross + extras) - ((gross + extras) * (withholding / 100)))"></span>
                                </p>
                            </article>
                        </div>
                    </section>

                    <section class="panel rounded-3xl p-5 md:p-6">
                        <h3 class="display-title text-3xl text-zinc-900">Actions</h3>
                        <p class="mt-2 text-sm text-zinc-700">Esta vista esta preparada para navegar con Livewire sin recarga completa.</p>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <a
                                href="/ui"
                                wire:navigate
                                class="rounded-full border border-teal-700 bg-teal-700 px-4 py-2 text-sm font-semibold text-white transition hover:bg-teal-800"
                            >
                                Reload lab
                            </a>
                            <a
                                href="/"
                                wire:navigate
                                class="rounded-full border border-zinc-700/35 px-4 py-2 text-sm font-semibold text-zinc-800 transition hover:border-zinc-900"
                            >
                                Back to welcome
                            </a>
                        </div>
                    </section>
                </aside>
            </main>
        </div>

        @livewireScripts
    </body>
</html>
