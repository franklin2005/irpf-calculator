<?php

return [
    // Progressive state (national) personal income tax brackets for 2026.
    // Each bracket uses:
    // - from: lower bound in EUR
    // - to: upper bound in EUR (null means no upper limit)
    // - rate: decimal tax rate applied to the taxable base inside the bracket
    'state_brackets' => [
        ['from' => 0, 'to' => 12450, 'rate' => 0.095],
        ['from' => 12450, 'to' => 20200, 'rate' => 0.12],
        ['from' => 20200, 'to' => 35200, 'rate' => 0.15],
        ['from' => 35200, 'to' => 60000, 'rate' => 0.185],
        ['from' => 60000, 'to' => null, 'rate' => 0.225],
    ],
    // Progressive Asturias regional brackets for 2026.
    'regional_brackets' => [
        ['from' => 0, 'to' => 12450, 'rate' => 0.10],
        ['from' => 12450, 'to' => 20200, 'rate' => 0.12],
        ['from' => 20200, 'to' => 35200, 'rate' => 0.15],
        ['from' => 35200, 'to' => 60000, 'rate' => 0.19],
        ['from' => 60000, 'to' => null, 'rate' => 0.23],
    ],
    // Personal minimums used to reduce taxable base in this MVP.
    // The calculator currently uses only "base".
    'personal_minimums' => [
        'base' => 5550,
        'over_65' => 1150,
        'over_75' => 1400,
    ],
    // Family minimums used to reduce taxable base in this MVP.
    // The calculator currently uses "per_child" multiplied by number of children.
    'family_minimums' => [
        'per_child' => 2400,
        'third_child_bonus' => 500,
    ],
    // Reserved for future extensions (advanced reductions are not applied yet).
    'reductions' => [
        'employment_income_general' => 2000,
    ],
];
