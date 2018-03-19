<?php
/**
 * This file is a part of the Framie.
 *
 * @author Dmitry Podosenov <screamie@yandex.ru>
 * @link http://framie.ru/
 * @copyright Copyright (c) 2018 Dmitry Podosenov
 * @license http://framie.ru/license/
 */

namespace nastybits\framie\console;

/**
 * Class App
 * @package framie\console
 *
 * Console commands for the most frequent actions
 */
class AppConsole extends BaseConsole
{
    public static $app;

    const NAMESCPACE = 'framie\console';

    public $config;
    public $request;

    /**
     * App constructor.
     * @param array $config
     * @param array $request
     * @param int $len
     */
    public function __construct(array $config, array $request, $len)
    {
        if (self::$app === null)
            self::$app = $this;

        if ($len > 1) {
            array_shift($request);
        }

        $this->config = $config;
        $this->request = $request;
    }

    /**
     *
     */
    public function run()
    {

        if (in_array($this->request[0], ['-h', '-help', '-?', '--help', 'app'])) {
            $this->help();
        }

        $r = explode('\\', self::NAMESCPACE . '\\' . array_shift($this->request));
        $action = array_pop($r);
        $className = ucfirst(array_pop($r)) . 'Console';
        $className = implode('\\', $r) . '\\' . $className;

        try {
            $refl = new \ReflectionClass($className);
        } catch (\ReflectionException $e) {
            die($e->getMessage());
        }

        $class = new $className;

        if (method_exists($class, $action)) {
            $class->{$action}();
        } else {
            die ('Application can not handle you request and will be closed! Type --help to see available commands');
        }

    }

    /**
     *
     */
    public function help()
    {
        $class = new CommandConsole();
        $class->help();
    }
}