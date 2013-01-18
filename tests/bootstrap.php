<?php
$composer = dirname(__DIR__) . '/vendor/autoload.php';
if (false === file_exists($composer)) {
    echo "Autoloader does not exist. Please `./composer.phar install`" . PHP_EOL;
    exit(1);
}
require $composer;