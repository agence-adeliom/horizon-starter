<?php

// Configuration globale du partage (utilisé par ex. dans le hero des articles de blog).
// Par défaut, tous les services sont affichés (tableau vide = tout activer).
// Décommenter un ou plusieurs services pour restreindre l'affichage à ceux-ci uniquement.

use Adeliom\HorizonTools\Services\ShareService;

return [
    'enable' => true,
    'services' => [
        // ShareService::SHARE_COPY_LINK,
        // ShareService::SHARE_BY_EMAIL,
        // ShareService::SHARE_BY_SMS,
        // ShareService::SHARE_BY_WHATSAPP,
        // ShareService::SHARE_BY_MESSENGER,
        // ShareService::SHARE_BY_CHATGPT,
        // ShareService::SHARE_BY_CLAUDE,
        // ShareService::SHARE_BY_PERPLEXITY,
    ],
];
