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
        ['from' => 0, 'to' => 12450, 'rate' => 0.101],
        ['from' => 12450, 'to' => 20200, 'rate' => 0.126],
        ['from' => 20200, 'to' => 35200, 'rate' => 0.156],
        ['from' => 35200, 'to' => 60000, 'rate' => 0.191],
        ['from' => 60000, 'to' => null, 'rate' => 0.231]
    ],
    'personal_minimums' => [
        'base' => 5850,
        'over_65' => 1210,
        'over_75' => 1475,
    ],
    'family_minimums' => [
        'per_child' => 2550,
        'third_child_bonus' => 530,
    ],
    'reductions' => [
        'employment_income_general' => 2250,
    ],
];

