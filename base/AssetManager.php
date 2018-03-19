<?php

namespace nastybits\framie\base;

use nastybits\framie\helpers\Html;

class AssetManager
{
    private $_path;

    public $js;
    public $css;

    public function __construct()
    {
        if(array_key_exists('path', Framie::$app->config['assets'])) {
            $this->_path = Framie::$app->config['assets']['path'];
        } else {
            $this->_path = '/assets/';
        }

    }

    /**
     * Load javascript files on page
     */
    public function loadJs()
    {
        $this->js = Framie::$app->config['assets']['js'];

        foreach ($this->js as $js) {

            if (!is_array($js)) {

                $path = preg_match('/^(https?).*/', $js) ? $js : $this->_path . $js;
                echo "<script src='" . $path . "'></script>";

            } else {
                $path = preg_match('/^(https?).*/', $js[0]) ? $js[0] : $this->_path . $js[0];
                $src = "src='" . $path . "'></script>";

                if (isset($js['options'])) {
                    echo "<script " . Html::getOptions($js['options']) . $src;
                } else {
                    echo "<script " . $src;
                }
            }
        }
    }

    /**
     * Load css files on page
     */
    public function loadCss()
    {
        $this->css = $this->parseBundles(Framie::$app->config['assets']['css']);

        foreach ($this->css as $css) {
            $path = preg_match('/^(https?).*/', $css) ? $css : $this->_path . $css;
            echo "<link rel='stylesheet' type='text/css' href='" . $path . "'>";
        }
    }

    /**
     * @param string|array $void
     */
    public function registerJs($void)
    {
        Framie::$app->config['assets']['js'][] = $void;
    }

    /**
     * @param $string
     */
    public function registerCss($string)
    {
        Framie::$app->config['assets']['css'][] = $string;
    }

    /**
     * @param $array
     * @return array
     */
    private function parseBundles($array)
    {
        $res = [];

        foreach ($array as $key => $val) {

            if (is_array($val)) {

                if (Framie::$app->view->layout !== $key)
                    continue;

                foreach ($val as $v) {
                    $res[] = $v;
                }

            } else {
                $res[] = $val;
            }
        }

        return $res;
    }
}