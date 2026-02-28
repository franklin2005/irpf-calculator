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
        ['from' => 0, 'to' => 12450, 'rate' => 0.08],
        ['from' => 12450, 'to' => 20200, 'rate' => 0.106],
        ['from' => 20200, 'to' => 35200, 'rate' => 0.136],
        ['from' => 35200, 'to' => 40000, 'rate' => 0.178],
        ['from' => 40000, 'to' => 50000, 'rate' => 0.183],
        ['from' => 50000, 'to' => 60000, 'rate' => 0.19],
        ['from' => 60000, 'to' => 120000, 'rate' => 0.245],
        ['from' => 120000, 'to' => null, 'rate' => 0.27]
    ],
    'personal_minimums' => [
        'base' => 5625,
        'over_65' => 1165,
        'over_75' => 1419,
    ],
    'family_minimums' => [
        'per_child' => 2425,
        'third_child_bonus' => 505,
    ],
    'reductions' => [
        'employment_income_general' => 2050,
    ],
];

