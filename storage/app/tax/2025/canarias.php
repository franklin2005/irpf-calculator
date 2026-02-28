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
        ['from' => 0, 'to' => 12450, 'rate' => 0.09],
        ['from' => 12450, 'to' => 17707, 'rate' => 0.115],
        ['from' => 17707, 'to' => 33007, 'rate' => 0.14],
        ['from' => 33007, 'to' => 53407, 'rate' => 0.185],
        ['from' => 53407, 'to' => 90000, 'rate' => 0.235],
        ['from' => 90000, 'to' => 120000, 'rate' => 0.25],
        ['from' => 120000, 'to' => null, 'rate' => 0.26]
    ],
    'personal_minimums' => [
        'base' => 5700,
        'over_65' => 1180,
        'over_75' => 1438,
    ],
    'family_minimums' => [
        'per_child' => 2475,
        'third_child_bonus' => 515,
    ],
    'reductions' => [
        'employment_income_general' => 2050,
    ],
];

