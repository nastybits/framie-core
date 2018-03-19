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

/**
 * Class Request
 * @package nastybits\framie
 */
class Request
{
    public $pathInfo;
    public $hash;
    public $isAjax = false;
    public $isPost = false;
    public $isGet = false;
    public $isPut = false;
    public $isDelete = false;

    /**
     * Request constructor.
     * @param $request
     */
    public function __construct($request)
    {
        $this->isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        $this->resolve($request);
    }

    /**
     * Resolve request to file path
     * @param $request
     */
    public function resolve($request)
    {
        if (array_key_exists('q', $request)) {
            $uri = explode('#', $request['q']);
            $this->pathInfo = $uri[0];
            $this->hash = (count($uri) > 1) ? '#'.$uri[1] : null;
        } else {
            $this->pathInfo = Framie::$app->config['defaultUrl'];
        }

        $this->pathInfo = '/' . ltrim($this->pathInfo, '/');
    }
}