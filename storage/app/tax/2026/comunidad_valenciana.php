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
        ['from' => 0, 'to' => 12450, 'rate' => 0.098],
        ['from' => 12450, 'to' => 20200, 'rate' => 0.123],
        ['from' => 20200, 'to' => 35200, 'rate' => 0.153],
        ['from' => 35200, 'to' => 60000, 'rate' => 0.188],
        ['from' => 60000, 'to' => null, 'rate' => 0.228]
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

