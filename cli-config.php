<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

include '../../../wp-config.php';

$config = Setup::createAnnotationMetadataConfiguration(array("App/Entity"), true, null, null, false);

$dbParams = array(
    'driver'   => 'pdo_mysql',    
	'host'	   => DB_HOST,
    'user'     => DB_USER,
    'password' => DB_PASSWORD,
    'dbname'   => DB_NAME,
);

$entityManager = EntityManager::create( $dbParams, $config );

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
