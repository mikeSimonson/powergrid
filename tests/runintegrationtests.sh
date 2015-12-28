#!/bin/bash

cd db
pwd
cp conf/.propel.json.sqlite3 conf/propel.json
if [ -z ${TEST_SQLITE3_DB_ABSOLUTE_PATH+x} ]; then TEST_SQLITE3_DB_ABSOLUTE_PATH="/var/www/db/integration_tests_sqlite3.db"; fi
echo "Using full path $TEST_SQLITE3_DB_ABSOLUTE_PATH for sqlite3 test database."
sed -i "s|TEST_SQLITE3_DB_ABSOLUTE_PATH|$TEST_SQLITE3_DB_ABSOLUTE_PATH|g" conf/propel.json
./propel_build.sh

cd ..
pwd
export $TEST_SQLITE3_DB_ABSOLUTE_PATH
php ./phpunit --configuration ./tests/phpunit_config/integration_tests.xml tests/automated/integration

cd db
pwd
echo "Cleaning up..."
cp conf/.propel.json.mysql conf/propel.json
./propel config:convert
