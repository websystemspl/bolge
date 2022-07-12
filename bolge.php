<?php
/**
* Plugin Name: Bolge
* description: Plugin boilerplate
* Version: 1.0.0
* Author: Web Systems
* Text Domain: bolge
*/

/* Avoid direct execute file  */
defined('ABSPATH') || exit;

/* Plugin path */
define('DIR_PATH', __DIR__);

global $table_prefix;

/* Autoload files */
require __DIR__ . '/vendor/autoload.php';

/* Default timezone */
date_default_timezone_set(get_option('timezone_string'));

/* Wordpress texdomain for translations */
load_plugin_textdomain('bolge', false, dirname(plugin_basename(__FILE__)) . '/languages');

/* App boot */
$app = Websystems\BolgeCore\BolgeCore::getInstance();
$app->setTablePrefix($table_prefix);
$app->setDirPath(__DIR__);
$app->setDbConnectionParams('pdo_mysql', DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
$app->boot(Symfony\Component\HttpFoundation\Request::createFromGlobals());

/* Run on activate  */
register_activation_hook(__FILE__, [$app, 'pluginActivate']);
