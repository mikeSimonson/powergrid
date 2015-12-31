<?php

if (!defined('BASE_DIR')) define('BASE_DIR', __DIR__);
if (!defined('SRC_DIR')) define('SRC_DIR', BASE_DIR . '/src');
if (!defined('HTTPAPI_DIR')) define('HTTPAPI_DIR', SRC_DIR . '/HTTPApi');

require_once(BASE_DIR . '/vendor/autoload.php');
require_once(BASE_DIR . '/db/generated-conf/config.php');

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Propel basic logging
$defaultLogger = new Logger('defaultLogger');
$defaultLogger->pushHandler(new StreamHandler('/var/log/propel.log', Logger::WARNING));
$serviceContainer->setLogger('defaultLogger', $defaultLogger);

function loadApiLib($className) {
  $parts = explode('\\', $className);

  if (array_shift($parts) === 'HTTPApi') {
    require(SRC_DIR . '/HTTPApi/' . implode('/', $parts) . '.php');
  }
}

function loadPowerGridLib($className) {
  $parts = explode('\\', $className);

  if (array_shift($parts) === 'PowerGrid') {
    require(SRC_DIR . '/PowerGrid/' . implode('/', $parts) . '.php');
  }
}

function loadHTTPPowerGridLib($className) {
  $parts = explode('\\', $className);

  if (array_shift($parts) === 'HTTPPowerGrid') {
    require(SRC_DIR . '/HTTPPowerGrid/' . implode('/', $parts) . '.php');
  }
}

spl_autoload_register('loadApiLib');
spl_autoload_register('loadPowerGridLib');
spl_autoload_register('loadHTTPPowerGridLib');

?>
