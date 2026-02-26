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
        ['from' => 0, 'to' => 12450, 'rate' => 0.094],
        ['from' => 12450, 'to' => 20200, 'rate' => 0.119],
        ['from' => 20200, 'to' => 35200, 'rate' => 0.149],
        ['from' => 35200, 'to' => 60000, 'rate' => 0.184],
        ['from' => 60000, 'to' => null, 'rate' => 0.224]
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

