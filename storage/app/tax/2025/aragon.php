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
        ['from' => 0, 'to' => 13973, 'rate' => 0.095],
        ['from' => 13973, 'to' => 21210, 'rate' => 0.12],
        ['from' => 21210, 'to' => 36960, 'rate' => 0.15],
        ['from' => 36960, 'to' => 52500, 'rate' => 0.185],
        ['from' => 52500, 'to' => 60000, 'rate' => 0.205],
        ['from' => 60000, 'to' => 80000, 'rate' => 0.23],
        ['from' => 80000, 'to' => 90000, 'rate' => 0.24],
        ['from' => 90000, 'to' => 130000, 'rate' => 0.25],
        ['from' => 130000, 'to' => null, 'rate' => 0.255]
    ],
    'personal_minimums' => [
        'base' => 5600,
        'over_65' => 1160,
        'over_75' => 1412,
    ],
    'family_minimums' => [
        'per_child' => 2425,
        'third_child_bonus' => 505,
    ],
    'reductions' => [
        'employment_income_general' => 2050,
    ],
];

