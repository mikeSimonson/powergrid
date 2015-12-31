#!/bin/bash
set -e

export TEST_SQLITE3_DB_ABSOLUTE_PATH
./tests/build_test_db.sh

cd ..
pwd
php ./phpunit --configuration ./tests/phpunit_config/integration_tests.xml tests/automated/integration

cd db
pwd
echo "Cleaning up..."
cp conf/.propel.json.mysql conf/propel.json
./propel config:convert
