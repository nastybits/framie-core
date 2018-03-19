<?php

/**
 * This file is a part of the Framie.
 *
 * @author Dmitry Podosenov <screamie@yandex.ru>
 * @link http://framie.ru/
 * @copyright Copyright (c) 2018 Dmitry Podosenov
 * @license http://framie.ru/license/
 */

namespace nastybits\framie\helpers;


class Html
{
    /**
     * @param array $list
     * @param array $options
     * @return string
     */
    public static function ul(array $list, $options = [])
    {
        $string = "<ul ". self::getOptions($options)." >";

        foreach ($list as $item) {

            $string .= "<li><a href='{$item['url']}'>{$item['title']}</a>";

            if(array_key_exists('ul', $item)) {
                $string .= self::ul($item['ul'], []);
            }

            $string .= "</li> \n";

        }


        $string .= "</ul>";

        return $string;
    }

    /**
     * @param $path
     * @return string
     */
    public static function svg($path)
    {
        if ($path[0] !== '/') {
            $path = 'assets/img/icons/' . $path . '.svg';
        } else {
            $path = substr($path, 1) . '.svg';
        }

        if (is_file($path)) {
            return file_get_contents($path);
        } else {
            return $path;
        }
    }

    /**
     * @param $content
     * @param $url
     * @param array $options
     * @return string
     */
    public static function a($content, $url, $options = [])
    {
        $options = self::getOptions($options);

        return "<a href=\"$url\" $options>$content</a>";
    }

    /**
     * @param $path
     * @param $url
     * @param array $options
     * @return string
     */
    public static function aSvg($path, $url, $options = [])
    {
        return self::a(self::svg($path), $url, $options);
    }

    /**
     * @param array $options
     * @return string
     */
    public static function getOptions(array $options = [])
    {
        $string = '';

        if (!empty($options)) {

            foreach ($options as $attr => $val) {
                $string .= "$attr=\"$val\" ";
            }
        }

        return trim($string);
    }
}