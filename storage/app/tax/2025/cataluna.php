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
        ['from' => 0, 'to' => 12450, 'rate' => 0.108],
        ['from' => 12450, 'to' => 17707, 'rate' => 0.123],
        ['from' => 17707, 'to' => 21000, 'rate' => 0.143],
        ['from' => 21000, 'to' => 33007, 'rate' => 0.154],
        ['from' => 33007, 'to' => 53407, 'rate' => 0.192],
        ['from' => 53407, 'to' => 90000, 'rate' => 0.219],
        ['from' => 90000, 'to' => 120000, 'rate' => 0.239],
        ['from' => 120000, 'to' => 175000, 'rate' => 0.249],
        ['from' => 175000, 'to' => null, 'rate' => 0.26]
    ],
    'personal_minimums' => [
        'base' => 5550,
        'over_65' => 1190,
        'over_75' => 1450,
    ],
    'family_minimums' => [
        'per_child' => 2400,
        'third_child_bonus' => 520,
    ],
    'reductions' => [
        'employment_income_general' => 2150,
    ],
];

