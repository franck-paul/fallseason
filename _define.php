<?php
/**
 * @brief fallseason, a theme for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Themes
 *
 * @copyright Franck Paul (carnet.franck.paul@gmail.com)
 * @copyright GPL-2.0
 */
if (!defined('DC_RC_PATH')) {
    return;
}

$this->registerModule(
    'FallSeason',                                                               // Name
    'A WP theme designed by Sadish Bala, adapted to DotClear 2 by Franck Paul', // Description
    'Franck Paul',                                                              // Author
    '1.5',                                                                      // Version
    [
        'requires' => [['core', '2.13']], // Dependencies
        'type'     => 'theme',            // Type

        'details'    => 'https://open-time.net/?q=fallseason',       // Details URL
        'support'    => 'https://github.com/franck-paul/fallseason', // Support URL
        'repository' => 'https://raw.githubusercontent.com/franck-paul/fallseason/main/dcstore.xml'
    ]
);
