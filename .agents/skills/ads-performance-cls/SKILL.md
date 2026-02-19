---
name: ads-performance-cls
description: Use when integrating Google Ads/analytics or placing ad slots. Focus on Core Web Vitals (CLS/LCP/INP) and preventing layout shifts.
---

## Goal
Monetize without tanking Core Web Vitals.

## Rules
- Reserve ad slots (min-height / fixed container) to reduce CLS.
- Avoid blocking render with heavy scripts.
- Prefer fewer ad slots on the calculator page initially.

## Verification
- Check CLS risk visually (no jumping content).
- Spot-check Lighthouse locally if possible.