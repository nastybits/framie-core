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

class Str
{
    public static function ucfirst($str)
    {
        return mb_strtoupper(mb_substr($str, 0, 1)) . mb_substr($str, 1);
    }
}
