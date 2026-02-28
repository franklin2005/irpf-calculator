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
        ['from' => 0, 'to' => 12985, 'rate' => 0.094],
        ['from' => 12985, 'to' => 21068, 'rate' => 0.12],
        ['from' => 21068, 'to' => 35200, 'rate' => 0.153],
        ['from' => 35200, 'to' => 60000, 'rate' => 0.188],
        ['from' => 60000, 'to' => null, 'rate' => 0.23]
    ],
    'personal_minimums' => [
        'base' => 5550,
        'over_65' => 1170,
        'over_75' => 1425,
    ],
    'family_minimums' => [
        'per_child' => 2400,
        'third_child_bonus' => 510,
    ],
    'reductions' => [
        'employment_income_general' => 2050,
    ],
];

