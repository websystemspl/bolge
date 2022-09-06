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

/** Wordpress table prefix */
global $table_prefix;

/* Autoload files */
require __DIR__ . '/vendor/autoload.php';

/* Default timezone */
date_default_timezone_set(get_option('timezone_string'));

/* Wordpress texdomain for translations */
load_plugin_textdomain('bolge', false, dirname(plugin_basename(__FILE__)) . '/languages');

/* App boot */
$app = Websystems\BolgeCore\BolgeCore::getInstance();

/**
 * Database table prefix (optional)
 */
$app->setTablePrefix($table_prefix);

/**
 * Dir path to app root directory
 */
$app->setDirPath(__DIR__);

/**
 * Database connection parameters
 */
$app->setDbConnectionParams('pdo_mysql', DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);

/**
 * Boot App
 */
$app->boot(Symfony\Component\HttpFoundation\Request::createFromGlobals());

/**
 * Core method to run update database schema
 * and additional event subscribers once
 * for example when plugin activated
 */
register_activation_hook(__FILE__, [$app, 'pluginActivate']);
