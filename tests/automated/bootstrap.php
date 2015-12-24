<?php

require_once('./bootstrap.php');

function loadTestClasses($className) {
  $parts = explode('\\', $className);

  if (array_shift($parts) === 'Tests') {
    require('./' . implode('/', $parts) . '.php');
  }
}

spl_autoload_register('loadTestClasses');
