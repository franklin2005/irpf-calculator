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
        ['from' => 12450, 'to' => 20200, 'rate' => 0.1],
        ['from' => 20200, 'to' => 24200, 'rate' => 0.16],
        ['from' => 24200, 'to' => 35200, 'rate' => 0.175],
        ['from' => 35200, 'to' => 60000, 'rate' => 0.21],
        ['from' => 60000, 'to' => 80200, 'rate' => 0.235],
        ['from' => 80200, 'to' => 99200, 'rate' => 0.24],
        ['from' => 99200, 'to' => 120200, 'rate' => 0.245],
        ['from' => 120200, 'to' => 300000, 'rate' => 0.25],
        ['from' => 300000, 'to' => null, 'rate' => 0.25]
    ],
    'personal_minimums' => [
        'base' => 5500,
        'over_65' => 1140,
        'over_75' => 1388,
    ],
    'family_minimums' => [
        'per_child' => 2375,
        'third_child_bonus' => 495,
    ],
    'reductions' => [
        'employment_income_general' => 1950,
    ],
];

