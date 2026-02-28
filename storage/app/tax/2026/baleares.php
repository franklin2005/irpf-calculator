<?php

return [
    'state_brackets' => [
        ['from' => 0, 'to' => 12450, 'rate' => 0.095],
        ['from' => 12450, 'to' => 20200, 'rate' => 0.12],
        ['from' => 20200, 'to' => 35200, 'rate' => 0.15],
        ['from' => 35200, 'to' => 60000, 'rate' => 0.185],
        ['from' => 60000, 'to' => null, 'rate' => 0.225]
    ],
    'regional_brackets' => [
        ['from' => 0, 'to' => 10000, 'rate' => 0.09],
        ['from' => 10000, 'to' => 18000, 'rate' => 0.1125],
        ['from' => 18000, 'to' => 30000, 'rate' => 0.1425],
        ['from' => 30000, 'to' => 48000, 'rate' => 0.175],
        ['from' => 48000, 'to' => 70000, 'rate' => 0.19],
        ['from' => 70000, 'to' => 90000, 'rate' => 0.2175],
        ['from' => 90000, 'to' => 120000, 'rate' => 0.2275],
        ['from' => 120000, 'to' => 175000, 'rate' => 0.2375],
        ['from' => 175000, 'to' => null, 'rate' => 0.2475]
    ],
    'personal_minimums' => [
        'base' => 5650,
        'over_65' => 1170,
        'over_75' => 1425,
    ],
    'family_minimums' => [
        'per_child' => 2450,
        'third_child_bonus' => 510,
    ],
    'reductions' => [
        'employment_income_general' => 2100,
    ],
];

