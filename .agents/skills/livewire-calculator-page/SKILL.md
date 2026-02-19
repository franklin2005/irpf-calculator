---
name: livewire-calculator-page
description: Use when building or modifying the IRPF calculator UI in Livewire 4 with Flux components. Do NOT implement tax rules in the component; call the domain/use case.
---

## Goal
Build a responsive calculator page with Livewire + Flux.

## Rules
- Livewire components orchestrate input → validation → call use case → render result.
- No tax logic in Livewire components (delegate to Domain/Application).
- Use Flux components (`<flux:*>`) whenever possible.
- Use `wire:model.debounce.300ms` for text inputs and provide loading states (`wire:loading`).

## UX Requirements
- Mobile-first layout; desktop uses 2 columns with sticky result panel.
- Inline validation errors, accessible labels, sensible defaults.
- Avoid layout shifts in result area.

## Verification
- Run relevant tests (feature/livewire if present).
- Manually check responsive layout at mobile + desktop.