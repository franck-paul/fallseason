<?php

/**
 * @brief fallseason, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul carnet.franck.paul@gmail.com
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

namespace Dotclear\Theme\fallseason;

class FrontendBehaviors
{
    public static function publicHeadContent(): string
    {
        echo
        '<style type="text/css">' . "\n" .
        '@import url(index.php?tf=' . FrontendTemplate::currentSeasonHelper() . '.css);' . "\n" .
        "</style>\n";

        return '';
    }
}
