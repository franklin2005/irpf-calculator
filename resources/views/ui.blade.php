<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>UI Playground</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @fluxAppearance
    </head>
    <body class="min-h-screen bg-zinc-50 text-zinc-900 antialiased">
        <main class="mx-auto max-w-4xl space-y-8 p-6 md:p-10">
            <header class="flex items-center justify-between gap-4">
                <flux:heading level="1" size="xl">UI playground</flux:heading>
                <flux:badge color="green" variant="solid">Flux UI Free</flux:badge>
            </header>

            <flux:card class="space-y-4">
                <div>
                    <flux:heading size="lg">Acciones</flux:heading>
                    <flux:text class="mt-1">Botones de ejemplo en variantes comunes.</flux:text>
                </div>

                <flux:button.group>
                    <flux:button variant="primary">Calcular</flux:button>
                    <flux:button variant="filled">Guardar</flux:button>
                    <flux:button variant="ghost">Limpiar</flux:button>
                </flux:button.group>
            </flux:card>

            <flux:card class="space-y-6">
                <div>
                    <flux:heading size="lg">Formulario</flux:heading>
                    <flux:text class="mt-1">Input, select y checkbox con componentes Flux.</flux:text>
                </div>

                <form class="space-y-4">
                    <flux:input label="Base imponible anual" placeholder="30000" />

                    <flux:select label="Tipo de contrato" placeholder="Selecciona una opcion...">
                        <flux:select.option value="general">General</flux:select.option>
                        <flux:select.option value="temporal">Temporal</flux:select.option>
                        <flux:select.option value="autonomo">Autonomo</flux:select.option>
                    </flux:select>

                    <flux:checkbox label="Aplicar minimos familiares" checked />

                    <flux:button type="submit" variant="primary">Enviar</flux:button>
                </form>
            </flux:card>

            <flux:callout
                variant="success"
                heading="Configuracion lista"
                text="Este playground usa componentes Flux UI Free."
            />

            <flux:card class="space-y-3">
                <flux:heading size="lg">Tabs o accordion</flux:heading>
                <flux:callout
                    variant="secondary"
                    heading="No disponible en esta instalacion"
                    text="El paquete Flux Free instalado no expone componentes tabs/accordion para uso directo."
                />
            </flux:card>
        </main>

        @fluxScripts
    </body>
</html>
