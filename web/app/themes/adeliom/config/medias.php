<?php

return [
    'allow' => [
        'svg' => true,
    ],
    'sanitize' => [
        'svg' => true,
    ],

    /*
     * Champs d'accessibilité ajoutés en BO par horizon-tools. À n'activer que si les templates du thème en tiennent
     * compte, sinon le BO proposerait des réglages sans effet en front.
     */
    'accessibility' => [
        'images' => true,
        'videos' => true,
    ],
];
