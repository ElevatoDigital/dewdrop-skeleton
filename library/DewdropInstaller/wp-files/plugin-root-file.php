<?php

/**
 * Plugin Name: Dewdrop Skeleton Project
 * Description: A new plugin created from the Dewdrop project skeleton.
 * Version: 1.0
 */

use Dewdrop\Pimple;

require_once __DIR__ . '/vendor/autoload.php';

$pimple = Pimple::getInstance();

$pimple['view'] = function () {
    $view = new \Dewdrop\View\View();
    return $view;
};

$pimple['admin']->registerComponentsInPath();

