<?php
// Ce fichier contient la configuration simple de JobHunt.

return [
    'enabled' => false,
    'provider' => 'local-sandbox',
    'features' => [
        'cv_optimizer',
        'cv_screening',
        'candidate_match',
    ],
    'ai_accent' => '#7C3AED',
    'decision_support_only' => true,
];
