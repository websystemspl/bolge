<?php
require_once __DIR__.'/../vendor/autoload.php';

$classLoader = new \Composer\Autoload\ClassLoader();
$classLoader->addPsr4('Bolge\\Test\\', __DIR__, true);
$classLoader->register();
