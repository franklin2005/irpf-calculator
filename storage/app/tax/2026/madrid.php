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
        ['from' => 0, 'to' => 12450, 'rate' => 0.093],
        ['from' => 12450, 'to' => 20200, 'rate' => 0.118],
        ['from' => 20200, 'to' => 35200, 'rate' => 0.148],
        ['from' => 35200, 'to' => 60000, 'rate' => 0.183],
        ['from' => 60000, 'to' => null, 'rate' => 0.223]
    ],
    'personal_minimums' => [
        'base' => 5800,
        'over_65' => 1200,
        'over_75' => 1462,
    ],
    'family_minimums' => [
        'per_child' => 2525,
        'third_child_bonus' => 525,
    ],
    'reductions' => [
        'employment_income_general' => 2200,
    ],
];

