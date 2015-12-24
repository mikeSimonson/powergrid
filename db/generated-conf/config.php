<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('powergrid', 'sqlite');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'settings' =>
  array (
    'charset' => 'utf8',
    'queries' =>
    array (
    ),
  ),
  'dsn' => 'sqlite:integration_tests_sqlite3.db',
  'user' => NULL,
  'password' => '',
  'classname' => '\\Propel\\Runtime\\Connection\\ConnectionWrapper',
));
$manager->setName('powergrid');
$serviceContainer->setConnectionManager('powergrid', $manager);
$serviceContainer->setDefaultDatasource('powergrid');