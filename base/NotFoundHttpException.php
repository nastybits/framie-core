<?php
/**
 * This file is a part of the Framie.
 *
 * @author Dmitry Podosenov <screamie@yandex.ru>
 * @link http://framie.ru/
 * @copyright Copyright (c) 2018 Dmitry Podosenov
 * @license http://framie.ru/license/
 */

namespace nastybits\framie\base;

class NotFoundHttpException extends BaseException
{
    public $shortMessage = "Page not found";
    public $shortCode = 404;

    public function getErrorMessage()
    {
        return "File <code>\"" . '/' . $this->getMessage() . "\"</code> was not found";
    }
}
