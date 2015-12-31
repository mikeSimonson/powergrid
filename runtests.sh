#!/bin/bash
set -e
SCRIPT_RELATIVE_PATH="`dirname \"$0\"`"

BASE_DIR="`( cd \"$SCRIPT_RELATIVE_PATH\" && pwd )`"

DB_RELATIVE_PATH="/db/integration_tests_sqlite3.db"

TEST_SQLITE3_DB_ABSOLUTE_PATH=$BASE_DIR$DB_RELATIVE_PATH

export BASE_DIR
export TEST_SQLITE3_DB_ABSOLUTE_PATH

./tests/rununittests.sh
./tests/runintegrationtests.sh
