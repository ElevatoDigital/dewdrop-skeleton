<?php

// On prod, most code is tucked into zend outside the doc root
if (file_exists(__DIR__ . '/../zend/')) {
    define('APPLICATION_PATH', realpath(__DIR__ . '/../zend/'));
} else {
    define('APPLICATION_PATH', realpath(__DIR__ . '/../'));
}

require_once APPLICATION_PATH . '/vendor/autoload.php';

use Dewdrop\Pimple;

/* @var $silex \Silex\Application */
$silex = Pimple::getInstance();

$silex->get(
    '/',
    function () {
        return file_get_contents(__DIR__ . '/dewdrop-index.html');
    }
);

Pimple::getResource('admin')->registerComponentsInPath();

$silex->run();
