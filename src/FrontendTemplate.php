<?php

/**
 * @brief fallseason, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul contact@open-time.net
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

namespace Dotclear\Theme\fallseason;

use ArrayObject;
use Dotclear\App;
use Dotclear\Helper\Html\Html;

class FrontendTemplate
{
    public static function currentSeason(): string
    {
        return '<?= ' . self::class . '::currentSeasonHelper() ?>';
    }

    public static function currentSeasonHelper(): string
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

    public static function showURLType(): string
    {
        $mode        = App::url()->getType();
        $request_uri = is_string($request_uri = $_SERVER['REQUEST_URI']) ? $request_uri : '';

        if ($request_uri === '') {
            return '';
        }

        return '<?= "mode=' . $mode . ' url=' . $request_uri . ' - blog=' . Html::stripHostURL(App::blog()->url()) . '" ?>';
    }

    /**
     * @param  ArrayObject<array-key, mixed>    $attr
     */
    public static function isCurrentPageItem(ArrayObject $attr): string
    {
        $mode = App::url()->getType();

        $current = false;

        $menu = isset($attr['menu']) && is_string($attr['menu']) ? $attr['menu'] : '';
        $item = isset($attr['item']) && is_string($attr['item']) ? $attr['item'] : '';

        switch ($menu) {
            case 'user-defined':
                // Compare item with current URL
                if ($item !== '' && $_SERVER['REQUEST_URI'] == Html::stripHostURL(App::blog()->url()) . $item) {
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

    /**
     * @param  ArrayObject<array-key, mixed>    $attr
     */
    public static function flagFirstPage(ArrayObject $attr): string
    {
        $flag = isset($attr['true']) ? 'true' : 'false';

        return '<?php $dc_fallSeason_flag_first_page = ' . $flag . '; ?>';
    }

    /**
     * @param  ArrayObject<array-key, mixed>    $attr
     */
    public static function flagFirstPageIf(ArrayObject $attr, string $content): string
    {
        $if = '';

        if (isset($attr['true'])) {
            $sign = (bool) $attr['true'] ? '' : '!';
            $if   = $sign . '$dc_fallSeason_flag_first_page';
        }

        if ($if !== '') {
            return '<?php if(' . $if . ') : ?>' . $content . '<?php endif; ?>';
        }

        return $content;
    }

    /**
     * @param  ArrayObject<array-key, mixed>    $attr
     */
    public static function flagFlashPost(ArrayObject $attr): string
    {
        $flag = isset($attr['true']) ? 'true' : 'false';

        return '<?php $dc_fall_season_flag_flash_post = ' . $flag . '; ?>';
    }

    /**
     * @param  ArrayObject<array-key, mixed>    $attr
     */
    public static function flagFlashPostIf(ArrayObject $attr, string $content): string
    {
        $if = '';

        if (isset($attr['true'])) {
            $sign = (bool) $attr['true'] ? '' : '!';
            $if   = $sign . '$dc_fall_season_flag_flash_post';
        }

        if ($if !== '') {
            return '<?php if(' . $if . ') : ?>' . $content . '<?php endif; ?>';
        }

        return $content;
    }
}
