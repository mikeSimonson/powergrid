<?php

// Script CWD should be the BASE_DIR
require_once('./bootstrap.php');

if (!defined('TEST_SQLITE3_DB_FILENAME') && getenv('TEST_SQLITE3_DB_ABSOLUTE_PATH')) define('TEST_SQLITE3_DB_FILENAME', getenv('TEST_SQLITE3_DB_ABSOLUTE_PATH'));
