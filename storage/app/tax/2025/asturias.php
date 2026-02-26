<?php

// 2025 Asturias tax table (approximate educational values).
// Schema intentionally mirrors 2026 to keep repository and domain compatibility.
return [
    // Progressive state (national) brackets.
    // Each bracket contains: from (EUR), to (EUR|null), rate (decimal).
    'state_brackets' => [
        ['from' => 0, 'to' => 12450, 'rate' => 0.094],
        ['from' => 12450, 'to' => 20200, 'rate' => 0.119],
        ['from' => 20200, 'to' => 35200, 'rate' => 0.149],
        ['from' => 35200, 'to' => 60000, 'rate' => 0.184],
        ['from' => 60000, 'to' => null, 'rate' => 0.224],
    ],
    // Progressive Asturias regional brackets.
    'regional_brackets' => [
        ['from' => 0, 'to' => 12450, 'rate' => 0.099],
        ['from' => 12450, 'to' => 20200, 'rate' => 0.119],
        ['from' => 20200, 'to' => 35200, 'rate' => 0.149],
        ['from' => 35200, 'to' => 60000, 'rate' => 0.188],
        ['from' => 60000, 'to' => null, 'rate' => 0.228],
    ],
    // Personal minimums (calculator currently uses "base").
    'personal_minimums' => [
        'base' => 5500,
        'over_65' => 1150,
        'over_75' => 1400,
    ],
    // Family minimums (calculator currently uses "per_child").
    'family_minimums' => [
        'per_child' => 2350,
        'third_child_bonus' => 500,
    ],
    // Reserved for future advanced reductions.
    'reductions' => [
        'employment_income_general' => 2000,
    ],
];
