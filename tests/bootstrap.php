<?php
require __DIR__ . '/../vendor/autoload.php';

define('PHPSAMLMD_TESTS_ROOT', __DIR__);
define('PHPSAMLMD_TESTS_CONFIG_FILE', PHPSAMLMD_TESTS_ROOT . '/config/tests.config.php');
define('PHPSAMLMD_TESTS_DATA_DIR', PHPSAMLMD_TESTS_ROOT . '/data');

/*
$loader = new \Composer\Autoload\ClassLoader();
$loader->add('SamlMdUnit', __DIR__ . '/src');
$loader->register();
*/
function _dump($value)
{
    error_log(print_r($value, true));
}