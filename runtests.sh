#!/bin/bash
set -e
./tests/rununittests.sh
TEST_SQLITE3_DB_ABSOLUTE_PATH="/var/www/db/integration_tests_sqlite3.db"
echo $TEST_SQLITE3_DB_ABSOLUTE_PATH
export TEST_SQLITE3_DB_ABSOLUTE_PATH
./tests/runintegrationtests.sh
