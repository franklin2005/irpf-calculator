---
name: tax-tables-files
description: Use when adding or updating tax tables by year/CCAA, file schemas, or repositories that load tables. Includes schema validation tests.
---

## Goal
Manage tax tables as versioned files with schema validation.

## Rules
- Tables live under `storage/app/tax/{year}/{ccaa}.php` (or the chosen data path).
- Add schema validation tests for every schema change.
- Prefer clear errors for missing/invalid tables.

## Workflow
1. Add/update the table file.
2. Update repository loader (e.g., FileTaxTableRepository).
3. Add/adjust schema tests + at least one calculation test using the new table.

## Verification
- Run schema tests and at least one calculation test.
- Run Pint on changed files.