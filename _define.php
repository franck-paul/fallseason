<?php

/**
 * @brief fallseason, a theme for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Themes
 *
 * @copyright Franck Paul (contact@open-time.net)
 * @copyright GPL-2.0
 */
declare(strict_types=1);

if (isset($this) && is_object($this) && method_exists($this, 'registerModule') && isset($this->id) && is_string($this->id)) {
    $this->registerModule(
        'FallSeason',
        'A WP theme designed by Sadish Bala, adapted to Dotclear 2 by Franck Paul',
        'Franck Paul',
        '7.1',
        [
            'date'     => '2026-04-15T18:15:19+0200',
            'requires' => [['core', '2.36']],
            'type'     => 'theme',
            'overload' => true,

            'details'    => 'https://open-time.net/?q=fallseason',
            'support'    => 'https://github.com/franck-paul/fallseason',
            'repository' => 'https://raw.githubusercontent.com/franck-paul/fallseason/main/dcstore.xml',
            'license'    => 'gpl2',
        ]
    );
}
