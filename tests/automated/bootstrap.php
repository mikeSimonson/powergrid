<?php

require_once('./bootstrap.php');

function loadTestClasses($className) {
  $parts = explode('\\', $className);

  if (array_shift($parts) === 'Tests') {
    require('./' . implode('/', $parts) . '.php');
  }
}

spl_autoload_register('loadTestClasses');

if (!defined('TEST_SQLITE3_DB_FILENAME')) define('TEST_SQLITE3_DB_FILENAME', BASE_DIR . '/db/integration_tests_sqlite3.db');
