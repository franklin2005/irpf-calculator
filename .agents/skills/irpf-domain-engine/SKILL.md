---
name: irpf-domain-engine
description: Use when implementing or changing IRPF calculation logic, DTOs, or breakdown outputs. Do NOT use for UI work. Applies to app/Domain/Irpf and tests for the tax engine.
---

## Goal
Implement IRPF calculation logic in a framework-agnostic way.

## Rules
- All tax logic lives in `app/Domain/Irpf`.
- Domain code must not depend on Laravel (no facades, no config(), no HTTP layer, no Eloquent).
- Use explicit types and small pure methods.
- Money is represented as `int` cents unless the codebase already uses a different standard.

## Workflow
1. Add/adjust PHPUnit tests first (or alongside changes).
2. Implement/modify domain services (e.g., `IrpfCalculator`) and DTOs (`TaxInput`, `TaxResult`, `TaxBreakdown`).
3. Keep breakdown output stable and documented via tests.

## Verification
- Run targeted tests: `php artisan test --compact --filter=...`
- Run Pint: `vendor/bin/pint --dirty --format agent`