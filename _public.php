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

if (!defined('DC_RC_PATH')) {return;}

# Behaviors
$core->addBehavior('publicHeadContent', array(__NAMESPACE__ . '\dcFallSeason', 'publicHeadContent'));

// Add Flag management to the template scheme

$core->tpl->addValue('FlagFirstPage', array(__NAMESPACE__ . '\dcFallSeason', 'flagFirstPage'));
$core->tpl->addBlock('FlagFirstPageIf', array(__NAMESPACE__ . '\dcFallSeason', 'flagFirstPageIf'));
$core->tpl->addValue('FlagFlashPost', array(__NAMESPACE__ . '\dcFallSeason', 'flagFlashPost'));
$core->tpl->addBlock('FlagFlashPostIf', array(__NAMESPACE__ . '\dcFallSeason', 'flagFlashPostIf'));

// Add Menu management to the template scheme

$core->tpl->addValue('showURLType', array(__NAMESPACE__ . '\dcFallSeason', 'showURLType'));
$core->tpl->addValue('isCurrentPageItem', array(__NAMESPACE__ . '\dcFallSeason', 'isCurrentPageItem'));
$core->tpl->addValue('currentSeason', array(__NAMESPACE__ . '\dcFallSeason', 'currentSeason'));

class dcFallSeason
{
    public static function publicHeadContent($core)
    {
        echo
        '<style type="text/css">' . "\n" .
        '@import url(' .
        $core->blog->settings->system->themes_url . '/' . $core->blog->settings->system->theme . '/' .
        self::currentSeasonHelper() . '.css);' . "\n" .
            "</style>\n";
    }

    public static function currentSeason($attr)
    {
        return '<?php echo ' . __NAMESPACE__ . '\dcFallSeason::currentSeasonHelper(); ?>';
    }

    public static function currentSeasonHelper()
    {
        $dates  = array(320, 621, 923, 1221);
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

    public static function showURLType($attr)
    {
        $core = &$GLOBALS['core'];
        $mode = $core->url->type;
        return '<?php echo "mode=' . $mode . ' url=' . $_SERVER['REQUEST_URI'] . ' - blog=' . \html::stripHostURL($core->blog->url) . '"; ?>';
    }

    public static function isCurrentPageItem($attr)
    {
        $core = &$GLOBALS['core'];
        $mode = $core->url->type;

        $current = false;

        if (isset($attr['menu'])) {
            $menu = (string) $attr['menu'];
        } else {
            $menu = '';
        }
        if (isset($attr['item'])) {
            $item = (string) $attr['item'];
        } else {
            $item = '';
        }

        switch ($menu) {
            case 'user-defined':
                if ($item != '') {
                    // Compare item with current URL
                    if ($_SERVER['REQUEST_URI'] == \html::stripHostURL($core->blog->url) . $item) {
                        $current = true;
                    }
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
        if (isset($attr['true'])) {
            $flag = 'true';
        } else {
            $flag = 'false';
        }
        return '<?php $dc_fallSeason_flag_first_page = ' . $flag . '; ?>';
    }

    public static function flagFirstPageIf($attr, $content)
    {
        $if = '';

        if (isset($attr['true'])) {
            $sign = (boolean) $attr['true'] ? '' : '!';
            $if   = $sign . '$dc_fallSeason_flag_first_page';
        }

        if ($if != '') {
            return '<?php if(' . $if . ') : ?>' . $content . '<?php endif; ?>';
        } else {
            return $content;
        }
    }

    public static function flagFlashPost($attr)
    {
        if (isset($attr['true'])) {
            $flag = 'true';
        } else {
            $flag = 'false';
        }
        return '<?php $dc_fall_season_flag_flash_post = ' . $flag . '; ?>';
    }

    public static function flagFlashPostIf($attr, $content)
    {
        $if = '';

        if (isset($attr['true'])) {
            $sign = (boolean) $attr['true'] ? '' : '!';
            $if   = $sign . '$dc_fall_season_flag_flash_post';
        }

        if ($if != '') {
            return '<?php if(' . $if . ') : ?>' . $content . '<?php endif; ?>';
        } else {
            return $content;
        }
    }
}
