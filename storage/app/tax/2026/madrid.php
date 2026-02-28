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
        ['from' => 0, 'to' => 13362, 'rate' => 0.085],
        ['from' => 13362, 'to' => 18004, 'rate' => 0.107],
        ['from' => 18004, 'to' => 35425, 'rate' => 0.128],
        ['from' => 35425, 'to' => 57320, 'rate' => 0.174],
        ['from' => 57320, 'to' => null, 'rate' => 0.205]
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

