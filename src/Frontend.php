<?php
/**
 * @brief fallseason, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Themes
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul carnet.franck.paul@gmail.com
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

namespace Dotclear\Theme\fallseason;

use Dotclear\App;
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
        App::behavior()->addBehaviors([
            'publicHeadContent' => FrontendBehaviors::publicHeadContent(...),
        ]);

        // Add Flag management to the template scheme

        App::frontend()->template()->addValue('FlagFirstPage', FrontendTemplate::flagFirstPage(...));
        App::frontend()->template()->addBlock('FlagFirstPageIf', FrontendTemplate::flagFirstPageIf(...));
        App::frontend()->template()->addValue('FlagFlashPost', FrontendTemplate::flagFlashPost(...));
        App::frontend()->template()->addBlock('FlagFlashPostIf', FrontendTemplate::flagFlashPostIf(...));

        // Add Menu management to the template scheme

        App::frontend()->template()->addValue('showURLType', FrontendTemplate::showURLType(...));
        App::frontend()->template()->addValue('isCurrentPageItem', FrontendTemplate::isCurrentPageItem(...));
        App::frontend()->template()->addValue('currentSeason', FrontendTemplate::currentSeason(...));

        return true;
    }
}
