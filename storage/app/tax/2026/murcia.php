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
        ['from' => 0, 'to' => 12450, 'rate' => 0.095],
        ['from' => 12450, 'to' => 20200, 'rate' => 0.112],
        ['from' => 20200, 'to' => 34000, 'rate' => 0.133],
        ['from' => 34000, 'to' => 60000, 'rate' => 0.179],
        ['from' => 60000, 'to' => null, 'rate' => 0.225]
    ],
    'personal_minimums' => [
        'base' => 5550,
        'over_65' => 1150,
        'over_75' => 1400,
    ],
    'family_minimums' => [
        'per_child' => 2400,
        'third_child_bonus' => 500,
    ],
    'reductions' => [
        'employment_income_general' => 2000,
    ],
];

