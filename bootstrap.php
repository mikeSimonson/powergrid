<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require_once('vendor/autoload.php');
require_once('db/generated-conf/config.php');

// Propel basic logging
$defaultLogger = new Logger('defaultLogger');
$defaultLogger->pushHandler(new StreamHandler('/var/log/propel.log', Logger::WARNING));
$serviceContainer->setLogger('defaultLogger', $defaultLogger);

function loadApiLib($className) {
  $parts = explode('\\', $className);

  if (array_shift($parts) === 'HTTPApi') {
    require('src/HTTPApi/' . implode('/', $parts) . '.php');
  }
}

function loadPowerGridLib($className) {
  $parts = explode('\\', $className);

  if (array_shift($parts) === 'PowerGrid') {
    require('src/PowerGrid/' . implode('/', $parts) . '.php');
  }
}

function loadHTTPPowerGridLib($className) {
  $parts = explode('\\', $className);

  if (array_shift($parts) === 'HTTPPowerGrid') {
    require('src/HTTPPowerGrid/' . implode('/', $parts) . '.php');
  }
}

spl_autoload_register('loadApiLib');
spl_autoload_register('loadPowerGridLib');
spl_autoload_register('loadHTTPPowerGridLib');

?>
