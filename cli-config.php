<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Websystems\BolgeCore\DoctrineExtensions\TablePrefix;

include '../../../wp-config.php';

global $table_prefix;

$config = Setup::createAnnotationMetadataConfiguration(array("App/Entity"), true, null, null, false);

$dbParams = array(
    'driver'   => 'pdo_mysql',    
	'host'	   => DB_HOST,
    'user'     => DB_USER,
    'password' => DB_PASSWORD,
    'dbname'   => DB_NAME,
);

$entityManager = EntityManager::create( $dbParams, $config );

$tablePrefix = new TablePrefix($table_prefix);
$entityManager->getEventManager()->addEventListener(\Doctrine\ORM\Events::loadClassMetadata, $tablePrefix);

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
