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
 * Class View
 * @package nastybits\framie
 */
class View
{
    const VIEW_PATH = 'views';

    public $layout = 'main';
    public $view;
    public $title;
    public $params = [];
    public $meta = [];

    /**
     * View constructor.
     * @param Request $request
     * @param array $config
     */
    public function __construct(Request $request, $config)
    {
        $this->view = self::VIEW_PATH . $request->pathInfo;
    }

    /**
     * @param bool $withExt
     * @return string
     */
    public function getLayout($withExt = false) : string
    {
        $path = self::VIEW_PATH . '/_layouts/' . $this->layout;
        return $withExt ? $path . '.php' : $path;
    }

    /**
     * Render HTML view with variables
     * @param string $view path to view file
     * @param array $vars php variables
     * @return string html view
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     */
    public function render($view, array $vars = []) : string
    {
        $path = is_dir($view)
            ? $view . Framie::$app->config['defaultUrl'] . '.php'
            : $view . '.php';

        if (!is_file($path)) {
            throw new NotFoundHttpException($path);
        }

        $_obInitialLevel_ = ob_get_level();

        ob_start();
        ob_implicit_flush(false);
        extract($vars, EXTR_OVERWRITE);

        try {
            require($path);
            return ob_get_clean();
        } catch (\Exception $e) {
            while (ob_get_level() > $_obInitialLevel_) {
                if (!@ob_end_clean()) {
                    ob_clean();
                }
            }
            throw $e;
        } catch (\Throwable $e) {
            while (ob_get_level() > $_obInitialLevel_) {
                if (!@ob_end_clean()) {
                    ob_clean();
                }
            }
            throw $e;
        }
    }

    /**
     * @param null|string $view
     * @param array $vars
     * @return string|array
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     */
    public function renderPage($view = null, array $vars = []) : string
    {
        if ($view === null) {
            $view = $this->view;
        }

        $content = $this->render($view, $vars);

        if (Framie::$app->request->isAjax) {
            return json_encode([
                'content' => $content,
                'title' => $this->title,
                'params' => $this->params,
                'meta' => $this->meta,
            ]);
        }

        return $this->render($this->getLayout(), [
            'content' => $content
        ]);
    }
}
