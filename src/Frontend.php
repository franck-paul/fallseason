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

namespace Dotclear\Plugin\fallseason;

use dcCore;
use dcNsProcess;

class Frontend extends dcNsProcess
{
    protected static $init = false; /** @deprecated since 2.27 */
    public static function init(): bool
    {
        static::$init = My::checkContext(My::FRONTEND);

        return static::$init;
    }

    public static function process(): bool
    {
        if (!static::$init) {
            return false;
        }

        # Behaviors
        dcCore::app()->addBehavior('publicHeadContent', [FrontendBehaviors::class, 'publicHeadContent']);

        // Add Flag management to the template scheme

        dcCore::app()->tpl->addValue('FlagFirstPage', [FrontendTemplate::class, 'flagFirstPage']);
        dcCore::app()->tpl->addBlock('FlagFirstPageIf', [FrontendTemplate::class, 'flagFirstPageIf']);
        dcCore::app()->tpl->addValue('FlagFlashPost', [FrontendTemplate::class, 'flagFlashPost']);
        dcCore::app()->tpl->addBlock('FlagFlashPostIf', [FrontendTemplate::class, 'flagFlashPostIf']);

        // Add Menu management to the template scheme

        dcCore::app()->tpl->addValue('showURLType', [FrontendTemplate::class, 'showURLType']);
        dcCore::app()->tpl->addValue('isCurrentPageItem', [FrontendTemplate::class, 'isCurrentPageItem']);
        dcCore::app()->tpl->addValue('currentSeason', [FrontendTemplate::class, 'currentSeason']);

        return true;
    }
}
