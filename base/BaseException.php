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

class BaseException extends \Exception
{
    public $shortMessage = "The error has occurred. Please, contact with resource administrator";
    public $shortCode = 500;

    /**
     * @return string
     */
    public function getView() : string
    {
        return 'views/' . Framie::$app->config['errorPage'][Framie::$app->config['language']];
    }

    /**
     * Returns error information, depending on the environment
     * @return string
     */
    public function getError()
    {
        if (ENV === 'dev') {
          return $this->getErrorTrace();
        }

        /** @var $view View */
        $view = Framie::$app->view;

        if (!$view instanceof View && !is_file($view->getLayout(true))) {
            // @TODO: Need log here.
            return $this->shortMessage;
        }

        return $view->renderPage($this->getView(), [
            'code' => $this->shortCode,
            'message' => $this->shortMessage
        ]);

    }

    /**
     * @return mixed
     */
    public function getErrorTrace()
    {
        return Framie::$app->view->render(__DIR__ . '/../views/errors/exception', [
            'error' => $this,
            'class' => get_called_class(),
        ]);
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->getMessage();
    }

    /**
     * @param array $args
     * @return string
     */
    public function parseArgs(array $args)
    {
        $res = '';

        foreach ($args as $arg) {
            $res .= is_array($arg) ? 'array, ' : $arg . ', ';
        }

        return rtrim($res, ', ');
    }

    /**
     * @return string
     */
    public function getTraceAsTable()
    {
        $trace = '';

        foreach ($this->getTrace() as $num => $v) {
            $trace .= "<tr><td>#$num</td>";
            $trace .= "<td><code>{$v['file']}:<b>{$v['line']}</b></code></td>";
            $trace .= "<td><code>{$v['class']}::<b>{$v['function']}(" . $this->parseArgs($v['args']) . ')</b></code></td></tr>';
        }

        return "<table><caption>STACK TRACE</caption>$trace</table>";
    }
}