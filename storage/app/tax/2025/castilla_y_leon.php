<?php

return [
    'state_brackets' => [
        ['from' => 0, 'to' => 12450, 'rate' => 0.094],
        ['from' => 12450, 'to' => 20200, 'rate' => 0.119],
        ['from' => 20200, 'to' => 35200, 'rate' => 0.149],
        ['from' => 35200, 'to' => 60000, 'rate' => 0.184],
        ['from' => 60000, 'to' => null, 'rate' => 0.224]
    ],
    'regional_brackets' => [
        ['from' => 0, 'to' => 12450, 'rate' => 0.096],
        ['from' => 12450, 'to' => 20200, 'rate' => 0.121],
        ['from' => 20200, 'to' => 35200, 'rate' => 0.151],
        ['from' => 35200, 'to' => 60000, 'rate' => 0.186],
        ['from' => 60000, 'to' => null, 'rate' => 0.226]
    ],
    'personal_minimums' => [
        'base' => 5575,
        'over_65' => 1165,
        'over_75' => 1419,
    ],
    'family_minimums' => [
        'per_child' => 2375,
        'third_child_bonus' => 505,
    ],
    'reductions' => [
        'employment_income_general' => 2050,
    ],
];

