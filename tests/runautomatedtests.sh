#!/bin/bash
set -e

export TEST_SQLITE3_DB_ABSOLUTE_PATH
$BASE_DIR/tests/build_test_db.sh

pwd
php $BASE_DIR/phpunit --configuration $BASE_DIR/tests/phpunit_config.xml $BASE_DIR/tests/automated

cd db
pwd
echo "Cleaning up..."
cp conf/.propel.json.mysql conf/propel.json
./propel config:convert
