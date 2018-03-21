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
 * Class Framie
 * @package nastybits\framie
 */
class Framie
{
    public static $app;

    public $params;
    public $config;
    public $request;
    public $assets;
    public $view;

    private $_errors = false;

    /**
     * Framie constructor.
     */
    private function __construct()
    {
    }

    /**
     * App constructor.
     * @param array $config
     * @param array $params
     * @return Framie
     */
    public static function instance($config, $params)
    {
        if (self::$app === null) {
            self::$app = new self;
        }

        try {
            self::$app->setAppConfig($config);
            self::$app->setAppParams($params);
        } catch (FatalException $e) {
            die($e->getError());
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        return self::$app;
    }

    /**
     * @param array $config
     * @return bool
     */
    private function validateConfig(array $config) : bool
    {
        $requiredConfig = ['siteName', 'language', 'errorPage'];

        foreach ($requiredConfig as $key) {
            if (!array_key_exists($key, $config)) {
                $this->_errors['config'][] = "The required configuration parameter $key is not set.";
            }
        }

        if (!empty($this->_errors['config'])) {
            return false;
        }

        return true;
    }

    /**
     * @param $config
     * @throws \Exception
     */
    private function setAppConfig($config)
    {
        if (!$this->validateConfig($config)) {
            throw new FatalException("FATAL ERROR: Invalid application configuration");
        }

        $this->config = $config;
    }

    /**
     * @param array $params
     * @return bool
     */
    private function validateParams($params) : bool
    {
        return is_array($params);
    }

    /**
     * @param $params
     * @throws FatalException
     */
    private function setAppParams($params)
    {
        if (!$this->validateParams($params)) {
            throw new FatalException("FATAL ERROR: Invalid application parameters");
        }

        $this->params = $params;
    }

    /**
     * Start application
     */
    public function run()
    {
        $output = null;

        try {
            self::$app->request  = new Request($_REQUEST);
            self::$app->view     = new View(self::$app->request, self::$app->config);
            self::$app->assets   = new AssetManager();

            $output = self::$app->view->renderPage();
        } catch (NotFoundHttpException $e) {
            $output = $e->getError();
        } catch (InvalidConfigException $e) {
            $output = $e->getError();
        } catch (BaseException $e) {
            $output = $e->getError();
        } catch (FatalException $e) {
            $output = $e->getError();
        } catch (\Exception $e) {
            $output = $e->getMessage();
        }

        exit($output);
    }
}
