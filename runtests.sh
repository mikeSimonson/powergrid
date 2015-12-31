#!/bin/bash
set -e
SCRIPT_RELATIVE_PATH="`dirname \"$0\"`"
SCRIPT_ABSOLUTE_PATH="`( cd \"$SCRIPT_RELATIVE_PATH\" && pwd )`"
DB_RELATIVE_PATH="/db/integration_tests_sqlite3.db"
TEST_SQLITE3_DB_ABSOLUTE_PATH=$SCRIPT_ABSOLUTE_PATH$DB_RELATIVE_PATH
echo $TEST_SQLITE3_DB_ABSOLUTE_PATH
export TEST_SQLITE3_DB_ABSOLUTE_PATH
./tests/rununittests.sh
./tests/runintegrationtests.sh
