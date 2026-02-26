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
        ['from' => 0, 'to' => 12450, 'rate' => 0.092],
        ['from' => 12450, 'to' => 20200, 'rate' => 0.117],
        ['from' => 20200, 'to' => 35200, 'rate' => 0.147],
        ['from' => 35200, 'to' => 60000, 'rate' => 0.182],
        ['from' => 60000, 'to' => null, 'rate' => 0.222]
    ],
    'personal_minimums' => [
        'base' => 5750,
        'over_65' => 1200,
        'over_75' => 1462,
    ],
    'family_minimums' => [
        'per_child' => 2475,
        'third_child_bonus' => 525,
    ],
    'reductions' => [
        'employment_income_general' => 2200,
    ],
];

