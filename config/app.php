<?php

return [
    'app_name' => 'JobHunt',
    'app_tagline' => "Let's Find Your Next Job.",
    'base_path' => dirname(__DIR__),
    'public_path' => dirname(__DIR__) . '/public',
    'base_url' => '/jobhunt/public',
    'env' => 'development',
    'debug' => true,
    'roles' => ['candidate', 'company', 'admin'],
];
