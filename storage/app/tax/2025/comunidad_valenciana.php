<?php

// NOTE: 2025 data currently mirrors 2026 for this region. Approximation until official tables are loaded.

return [
    'state_brackets' => [
        ['from' => 0, 'to' => 12450, 'rate' => 0.095],
        ['from' => 12450, 'to' => 20200, 'rate' => 0.12],
        ['from' => 20200, 'to' => 35200, 'rate' => 0.15],
        ['from' => 35200, 'to' => 60000, 'rate' => 0.185],
        ['from' => 60000, 'to' => null, 'rate' => 0.225]
    ],
    'regional_brackets' => [
        ['from' => 0, 'to' => 12000, 'rate' => 0.09],
        ['from' => 12000, 'to' => 22000, 'rate' => 0.12],
        ['from' => 22000, 'to' => 32000, 'rate' => 0.15],
        ['from' => 32000, 'to' => 42000, 'rate' => 0.175],
        ['from' => 42000, 'to' => 52000, 'rate' => 0.2],
        ['from' => 52000, 'to' => 65000, 'rate' => 0.225],
        ['from' => 65000, 'to' => 72000, 'rate' => 0.25],
        ['from' => 72000, 'to' => 100000, 'rate' => 0.265],
        ['from' => 100000, 'to' => 150000, 'rate' => 0.275],
        ['from' => 150000, 'to' => 200000, 'rate' => 0.285],
        ['from' => 200000, 'to' => null, 'rate' => 0.295]
    ],
    'personal_minimums' => [
        'base' => 5600,
        'over_65' => 1160,
        'over_75' => 1412,
    ],
    'family_minimums' => [
        'per_child' => 2450,
        'third_child_bonus' => 510,
    ],
    'reductions' => [
        'employment_income_general' => 2100,
    ],
];

