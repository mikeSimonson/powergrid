<?php

require_once('vendor/autoload.php');

function loadApiLib($className) {
  $parts = explode('\\', $className);

  if (array_shift($parts) === 'Api') {
    require('apilib/' . implode('/', $parts) . '.php');
  }
}

spl_autoload_register('loadApiLib');

?>
