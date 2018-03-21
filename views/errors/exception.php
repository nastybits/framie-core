<?php
/**
 * This file is a part of the Framie.
 *
 * @author Dmitry Podosenov <screamie@yandex.ru>
 * @link http://framie.ru/
 * @copyright Copyright (c) 2018 Dmitry Podosenov
 * @license http://framie.ru/license/
 */


/**
 * @var $this nastybits\framie\base\View
 * @var $error nastybits\framie\base\BaseException
 * @var $class string
 */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <title><?= $this->title ?></title>
    <style>
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            background: #eee;
        }

        h1, h2, h3, h4, h5, h6 {
            margin: 0 0 20px 0;
            padding: 0 0 0 0;
        }

        header {
            background: #ccc;
            padding: 20px 30px 10px 30px;
            margin-bottom: 30px;
            box-sizing: border-box;
        }

        .middle {
            padding: 0 30px 30px 30px;
            box-sizing: border-box;
        }

        small {
            color: #888;
            display: block;
            font-size: 13px;
        }

        table {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 15px;
        }
        caption {
            text-align: left;
            font-size: 20px;
        }

        td {
            padding: 5px 10px;
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <header>
        <h2><?= substr(strrchr($class, '\\'), 1) . ": " .$error->getErrorMessage() ?>.
            <small>
                You see this error trace because you start application under development(dev)
                environment. Do not use this type of environment on production server.
            </small>
        </h2>
    </header>
    <main class="middle">
        <h3><?= $error->getErrorMessage() . " in " . $error->getFile() . ":" . $error->getLine()?></h3>
        <?= $error->getTraceAsTable() ?>
    </main>
</div>
</body>
</html>
