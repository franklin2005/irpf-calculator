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
        ['from' => 0, 'to' => 12450, 'rate' => 0.096],
        ['from' => 12450, 'to' => 20200, 'rate' => 0.121],
        ['from' => 20200, 'to' => 35200, 'rate' => 0.151],
        ['from' => 35200, 'to' => 60000, 'rate' => 0.186],
        ['from' => 60000, 'to' => null, 'rate' => 0.226]
    ],
    'personal_minimums' => [
        'base' => 5500,
        'over_65' => 1140,
        'over_75' => 1388,
    ],
    'family_minimums' => [
        'per_child' => 2375,
        'third_child_bonus' => 495,
    ],
    'reductions' => [
        'employment_income_general' => 1950,
    ],
];

