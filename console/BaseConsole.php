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


use ReflectionMethod;

class BaseConsole
{
    private static $indent = 40;

    /**
     * @return string
     */
    protected static function classname()
    {
        return get_called_class();
    }

    /**
     * Print help information
     */
    public function help()
    {
        die($this->getMethodsInfo());
    }

    /**
     * @return \ReflectionClass
     */
    private function getReflectionClass()
    {
        return new \ReflectionClass($this);
    }

    /**
     * @return string
     */
    protected function getMethodsInfo()
    {
        $class = $this->getReflectionClass();
        $className = str_replace(['framie\\console\\', 'Console'], '', $class->name);

        $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);

        $info = ['Available commands: '];

        foreach ($methods as $method) {
            $n = lcfirst($className.'\\'.$method->name);
            $c = trim(str_replace(['/', '*'], [''], $method->getDocComment()));

            $info[] = ' - ' .$n .$this->setIndent($n) .$c;
        }

        return implode(PHP_EOL, $info) . PHP_EOL;
    }

    /**
     * @param $str
     * @return string
     */
    private function setIndent($str){
        $indent = ' ';
        $i = self::$indent - strlen($str);

        while ($i > 0) {
            $indent .= ' ';
            $i--;
        }

        return $indent;
    }
}