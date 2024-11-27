<?php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Cible les routes API et Sanctum
    'allowed_methods' => ['*'], // Autorise toutes les méthodes (GET, POST, etc.)
    'allowed_origins' => ['http://localhost:3000'], // Domaine du frontend Next.js
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'], // Autorise tous les headers
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // Nécessaire pour Sanctum avec cookies
];
