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
 * The Creator class provides the creation of pages, templates and widgets.
 * See --help for more info
 */
class CommandConsole extends BaseConsole
{
    /**
     * Create new page by template
     * @param null|string $template
     */
    public function createPage($template = null)
    {
        $name = '';

        while (!$name) {
            echo "Enter new page name: ";
            $name = trim(fgets(STDIN));
        }

        echo "######################## ERROR ####################################" .PHP_EOL;
        echo "#: Can not create file \"" . $name . ".php\"" .PHP_EOL;
        echo "#: Need to add logic for CommandConsole::createPage() function." .PHP_EOL;
        echo "###################################################################".PHP_EOL;
        die();
    }

    /**
     * Create new widget by template
     * @param null|string $widgetName
     */
    public function createWidget($widgetName = null)
    {
        $name = '';

        while (!$name) {
            echo "Enter new widget name: ";
            $name = trim(fgets(STDIN));
        }

        echo "######################## ERROR ####################################" .PHP_EOL;
        echo "#: Can not create widget \"" . $name . ".php\"" .PHP_EOL;
        echo "#: Need to add logic for CommandConsole::createWidget() function." .PHP_EOL;
        echo "###################################################################".PHP_EOL;
        die();
    }

    /**
     * Download Layout SCSS library
     * @param string $version = 'full' [full|base|grids-only]
     */
    public function getSCSSLibrary($version = 'full')
    {
        echo "######################## ERROR ####################################" .PHP_EOL;
        echo "#: Can not get " .$version. " version of SCSS library." .PHP_EOL;
        echo "#: Need to add logic for CommandConsole::getSCSSLibrary() function." .PHP_EOL;
        echo "###################################################################".PHP_EOL;
        die();
    }

    /**
     * Download last version of JQUERY
     */
    public function getJQuery()
    {
        echo "######################## ERROR ####################################" .PHP_EOL;
        echo "#: Can not get JQuery." .PHP_EOL;
        echo "#: Need to add logic for CommandConsole::getJQuery() function." .PHP_EOL;
        echo "###################################################################".PHP_EOL;
        die();
    }
}