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

namespace themes\fallseason;

if (!defined('DC_RC_PATH')) {
    return;
}

# Behaviors
\dcCore::app()->addBehavior('publicHeadContent', [__NAMESPACE__ . '\dcFallSeason', 'publicHeadContent']);

// Add Flag management to the template scheme

\dcCore::app()->tpl->addValue('FlagFirstPage', [__NAMESPACE__ . '\dcFallSeason', 'flagFirstPage']);
\dcCore::app()->tpl->addBlock('FlagFirstPageIf', [__NAMESPACE__ . '\dcFallSeason', 'flagFirstPageIf']);
\dcCore::app()->tpl->addValue('FlagFlashPost', [__NAMESPACE__ . '\dcFallSeason', 'flagFlashPost']);
\dcCore::app()->tpl->addBlock('FlagFlashPostIf', [__NAMESPACE__ . '\dcFallSeason', 'flagFlashPostIf']);

// Add Menu management to the template scheme

\dcCore::app()->tpl->addValue('showURLType', [__NAMESPACE__ . '\dcFallSeason', 'showURLType']);
\dcCore::app()->tpl->addValue('isCurrentPageItem', [__NAMESPACE__ . '\dcFallSeason', 'isCurrentPageItem']);
\dcCore::app()->tpl->addValue('currentSeason', [__NAMESPACE__ . '\dcFallSeason', 'currentSeason']);

class dcFallSeason
{
    public static function publicHeadContent()
    {
        echo
        '<style type="text/css">' . "\n" .
        '@import url(' .
        \dcCore::app()->blog->settings->system->themes_url . '/' . \dcCore::app()->blog->settings->system->theme . '/' .
        self::currentSeasonHelper() . '.css);' . "\n" .
            "</style>\n";
    }

    public static function currentSeason()
    {
        return '<?php echo ' . __NAMESPACE__ . '\dcFallSeason::currentSeasonHelper(); ?>';
    }

    public static function currentSeasonHelper()
    {
        $dates  = [320, 621, 923, 1221];
        $today  = getdate();
        $serial = $today['mon'] * 100 + $today['mday'];

        if (($serial >= $dates[0]) && ($serial < $dates[1])) {
            $season = 'spring';
        } elseif (($serial >= $dates[1]) && ($serial < $dates[2])) {
            $season = 'summer';
        } elseif (($serial >= $dates[2]) && ($serial < $dates[3])) {
            $season = 'autumn';
        } else {
            $season = 'winter';
        }

        return $season;
    }

    public static function showURLType()
    {
        $mode = \dcCore::app()->url->type;

        return '<?php echo "mode=' . $mode . ' url=' . $_SERVER['REQUEST_URI'] . ' - blog=' . \html::stripHostURL(\dcCore::app()->blog->url) . '"; ?>';
    }

    public static function isCurrentPageItem($attr)
    {
        $mode = \dcCore::app()->url->type;

        $current = false;

        $menu = isset($attr['menu']) ? (string) $attr['menu'] : '';
        $item = isset($attr['item']) ? (string) $attr['item'] : '';

        switch ($menu) {
            case 'user-defined':
                // Compare item with current URL
                if ($item != '' && $_SERVER['REQUEST_URI'] == \html::stripHostURL(\dcCore::app()->blog->url) . $item) {
                    $current = true;
                }

                break;

            default:
                if ($menu == $mode) {
                    $current = true;
                }

                break;
        }

        return (string) ($current ? ' current_page_item' : '');
    }

    public static function flagFirstPage($attr)
    {
        $flag = isset($attr['true']) ? 'true' : 'false';

        return '<?php $dc_fallSeason_flag_first_page = ' . $flag . '; ?>';
    }

    public static function flagFirstPageIf($attr, $content)
    {
        $if = '';

        if (isset($attr['true'])) {
            $sign = (bool) $attr['true'] ? '' : '!';
            $if   = $sign . '$dc_fallSeason_flag_first_page';
        }

        if ($if != '') {
            return '<?php if(' . $if . ') : ?>' . $content . '<?php endif; ?>';
        }

        return $content;
    }

    public static function flagFlashPost($attr)
    {
        $flag = isset($attr['true']) ? 'true' : 'false';

        return '<?php $dc_fall_season_flag_flash_post = ' . $flag . '; ?>';
    }

    public static function flagFlashPostIf($attr, $content)
    {
        $if = '';

        if (isset($attr['true'])) {
            $sign = (bool) $attr['true'] ? '' : '!';
            $if   = $sign . '$dc_fall_season_flag_flash_post';
        }

        if ($if != '') {
            return '<?php if(' . $if . ') : ?>' . $content . '<?php endif; ?>';
        }

        return $content;
    }
}
