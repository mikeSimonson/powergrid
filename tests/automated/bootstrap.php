<?php

require_once('./bootstrap.php');

function loadTestClasses($className) {
  $parts = explode('\\', $className);

  if (array_shift($parts) === 'Tests') {
    require('./' . implode('/', $parts) . '.php');
  }
}

spl_autoload_register('loadTestClasses');

if (!defined('TEST_SQLITE3_DB_FILENAME') && getenv('TEST_SQLITE3_DB_ABSOLUTE_PATH')) define('TEST_SQLITE3_DB_FILENAME', getenv('TEST_SQLITE3_DB_ABSOLUTE_PATH'));
