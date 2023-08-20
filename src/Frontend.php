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

use dcCore;
use Dotclear\Core\Process;

class Frontend extends Process
{
    public static function init(): bool
    {
        return self::status(My::checkContext(My::FRONTEND));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        # Behaviors
        dcCore::app()->addBehavior('publicHeadContent', FrontendBehaviors::publicHeadContent(...));

        // Add Flag management to the template scheme

        dcCore::app()->tpl->addValue('FlagFirstPage', FrontendTemplate::flagFirstPage(...));
        dcCore::app()->tpl->addBlock('FlagFirstPageIf', FrontendTemplate::flagFirstPageIf(...));
        dcCore::app()->tpl->addValue('FlagFlashPost', FrontendTemplate::flagFlashPost(...));
        dcCore::app()->tpl->addBlock('FlagFlashPostIf', FrontendTemplate::flagFlashPostIf(...));

        // Add Menu management to the template scheme

        dcCore::app()->tpl->addValue('showURLType', FrontendTemplate::showURLType(...));
        dcCore::app()->tpl->addValue('isCurrentPageItem', FrontendTemplate::isCurrentPageItem(...));
        dcCore::app()->tpl->addValue('currentSeason', FrontendTemplate::currentSeason(...));

        return true;
    }
}
