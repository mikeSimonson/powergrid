<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require_once('vendor/autoload.php');
require_once('db/generated-conf/config.php');

$defaultLogger = new Logger('defaultLogger');
$defaultLogger->pushHandler(new StreamHandler('/var/log/propel.log', Logger::WARNING));
$serviceContainer->setLogger('defaultLogger', $defaultLogger);

function loadApiLib($className) {
  $parts = explode('\\', $className);

  if (array_shift($parts) === 'Api') {
    require('apilib/' . implode('/', $parts) . '.php');
  }
}

spl_autoload_register('loadApiLib');

?>
